<?php

/**
 * Установка локали
 */
setlocale(LC_ALL, 'ru_RU.UTF-8');

/**
 * Установка часового пояса
 */
date_default_timezone_set('UTC');

/**
 * Расширенная инициализация фреймворка
 */
fenric()->advancedInit();

/**
 * Регистрация корневого пути приложения
 */
fenric()->registerPath('.', function() : string
{
	return __DIR__;
});

/**
 * Регистрация обработчика неперехваченных исключений
 */
fenric()->registerUncaughtExceptionHandler(function($exception) : void
{
	if (! fenric()->is('cli'))
	{
		fenric('response')->setStatus(503);

		if (! fenric()->is('production'))
		{
			fenric('request')->isAjax()

			? fenric('response')->setJsonContent([

				// Inner rules API.
				'success' => false,
				'message' => $exception->getMessage(),

				// Debug information, only for developers.
				'file'    => $exception->getFile(),
				'line'    => $exception->getLine(),
			])

			: fenric('response')->setContent(
				fenric('view::errors/fatal')->render([
					'exception' => $exception,
				])
			);
		}

		while (ob_get_level() > 0) {
			ob_end_clean();
		}

		fenric('response')->send();

		exit(1);
	}
});

/**
 * Регистрация в контейнере фреймворка одиночной службы для получение информации о текущем релизе приложения
 */
fenric()->registerDisposableSharedService('release', function()
{
	return new \Fenric\Release();
});

/**
 * Регистрация в контейнере фреймворка приложения
 */
fenric()->registerDisposableSharedService('app', function()
{
	return new \Fenric\App();
});

/**
 * Регистрация в контейнере фреймворка одиночной службы для работы с учетной записью пользователя
 */
fenric()->registerDisposableSharedService('user', function()
{
	return new \Fenric\User();
});

/**
 * Регистрация в контейнере фреймворка именованной службы для вывода опроса
 */
fenric()->registerResolvableSharedService('poll', function(string $resolver, string $default = null)
{
	$query = \Propel\Models\PollQuery::create();

	$resolver = strtr($resolver, '.', '-');

	if (0 === strcmp($resolver, 'random'))
	{
		$resolver = \Propel\Models\PollQuery::getRandomCode();
	}

	$model = $query->findOneByCode($resolver);

	if ($model instanceof \Propel\Models\Poll)
	{
		return $model->render();
	}

	return $default;
});

/**
 * Регистрация в контейнере фреймворка именованной службы для вывода баннера
 */
fenric()->registerResolvableSharedService('banner', function(string $resolver, string $default = null)
{
	$query = \Propel\Models\BannerGroupQuery::create();

	$resolver = strtr($resolver, '.', '-');

	$model = $query->findOneByCode($resolver);

	if ($model instanceof \Propel\Models\BannerGroup)
	{
		return $model->render(true);
	}

	return $default;
});

/**
 * Регистрация в контейнере фреймворка именованной службы для вывода сниппета
 */
fenric()->registerResolvableSharedService('snippet', function(string $resolver, string $default = null)
{
	$query = \Propel\Models\SnippetQuery::create();

	$resolver = strtr($resolver, '.', '-');

	$model = $query->findOneByCode($resolver);

	if ($model instanceof \Propel\Models\Snippet)
	{
		return $model->getParsedValue();
	}

	return $default;
});

/**
 * Регистрация в контейнере фреймворка именованной службы для вывода параметра
 */
fenric()->registerResolvableSharedService('parameter', function(string $resolver, string $default = null)
{
	$query = \Propel\Models\ParameterQuery::create();

	$resolver = strtr($resolver, '.', '_');

	$model = $query->findOneByCode($resolver);

	if ($model instanceof \Propel\Models\Parameter)
	{
		return snippetable($model->getValue());
	}

	return $default;
});

/**
 * Регистрация в контейнере фреймворка именованной службы для работы с почтовым отправителем
 */
fenric()->registerResolvableSharedService('mailer', function(string $resolver = 'default')
{
	$mail = new PHPMailer();

	if (fenric('config::mailing')->get($resolver) instanceof Closure)
	{
		fenric('config::mailing')->get($resolver)->call($mail);
	}

	return $mail;
});

/**
 * Событие наступающее при создании учетной записи
 */
fenric('event::user.created')->subscribe(function(\Propel\Models\User $model)
{
	if ($model->isRegistrationConfirmed()) {
		return;
	}

	$mail = fenric('mailer');

	$mail->addAddress($model->getEmail());

	$mail->Subject = fenric()->t('user', 'email.registration.subject', [
		'host' => fenric('request')->environment->get('HTTP_HOST') ?: 'localhost',
	]);

	$mail->Body = fenric('view::mails/user.registration.confirmation', [
		'user' => $model,
		'url' => sprintf('%s://%s%s/user/registration/%s/',
			fenric('request')->getScheme(),
			fenric('request')->environment->get('HTTP_HOST') ?: 'localhost',
			fenric('request')->getRoot(),
			$model->getRegistrationConfirmationCode()
		),
	])->render();

	$mail->send();
});

/**
 * Событие наступающее при создании аутентификационного токена для учетной записи
 */
fenric('event::user.authentication.token.created')->subscribe(function(\Propel\Models\User $model)
{
	$mail = fenric('mailer');

	$mail->addAddress($model->getEmail());

	$mail->Subject = fenric()->t('user', 'email.authentication.token.subject', [
		'host' => fenric('request')->environment->get('HTTP_HOST') ?: 'localhost',
	]);

	$mail->Body = fenric('view::mails/user.authentication.token', [
		'user' => $model,
		'url' => sprintf('%s://%s%s/user/login/%s/',
			fenric('request')->getScheme(),
			fenric('request')->environment->get('HTTP_HOST') ?: 'localhost',
			fenric('request')->getRoot(),
			$model->getAuthenticationToken()
		),
	])->render();

	$mail->send();
});

/**
 * Короткий способ локализации сообщения
 */
function __(string $section, string $message, array $context = []) : string
{
	return fenric()->t($section, $message, $context);
}

/**
 * IP адрес клиента
 */
function ip() : string
{
	$env = fenric('request')->environment;

	return $env->get('REMOTE_ADDR', '127.0.0.1');
}

/**
 * Сборка URL c возможностью переназначения параметров запроса
 */
function url(array $queries = []) : string
{
	$url = '';

	if (fenric('request')->getHost())
	{
		if (fenric('request')->getScheme())
		{
			$url .= fenric('request')->getScheme() . '://';
		}

		$url .= fenric('request')->getHost();

		if (fenric('request')->getPort())
		{
			$url .= ':' . fenric('request')->getPort();
		}
	}

	if (fenric('request')->getPath())
	{
		$url .= fenric('request')->getPath();
	}

	$query = fenric('request')->query->all();

	if (count($queries) > 0)
	{
		foreach ($queries as $key => $value)
		{
			if (empty($value))
			{
				unset($query[$key]);

				continue;
			}

			$query[$key] = $value;
		}
	}

	if (count($query) > 0)
	{
		$url .= '?' . http_build_query($query);
	}

	return $url;
}

/**
 * Подтверждение местоположения
 */
function here(string $location) : bool
{
	$sanitized = addcslashes($location, '\.+?[^]${}=!|:-#');

	$expression = str_replace(['(', '*', '%', ')'], ['(?:', '[^/]*', '.*?', ')?'], $sanitized);

	return !! preg_match("#^{$expression}$#u", fenric('request')->getPath());
}

/**
 * Формирование ревизионного адреса статичного файла
 */
function asset(string $location) : string
{
	$absolute = fenric()->path('public', $location);

	if ($filename = realpath($absolute))
	{
		$lastModified = filemtime($filename);

		return sprintf('%s?%s', $location, $lastModified);
	}

	return $location;
}

/**
 * Форматирование строки для использования ее в URL
 */
function sluggable(string $value, string $separator = '-') : string
{
	$value = transliterator_transliterate('Any-Latin; Latin-ASCII; Lower()', $value);

	$value = preg_replace(['/[^a-z0-9-]/', '/-+/'], $separator, $value);

	$value = trim($value, $separator);

	return $value;
}

/**
 * Форматирование строки для использования ее в поиске
 */
function searchable(string $value, int $maxLength = 64, string $wordSeparator = ' ') : string
{
	$value = mb_strtolower($value, 'UTF-8');

	$value = preg_replace(['/[^\040\p{L}\p{N}]/u', '/\040+/'], ' ', $value);

	$value = trim($value);

	$value = mb_substr($value, 0, $maxLength, 'UTF-8');

	$value = rtrim($value);

	$value = str_replace(' ', $wordSeparator, $value);

	return $value;
}

/**
 * Форматирование сниппетов в строке
 */
function snippetable(string $value = null) : string
{
	$expression = '/{#(?<type>[a-z]+):(?<code>[a-zA-Z0-9-\.]{1,255})(?:\050(?<json>{[^\050\051]+})\051)?#}/su';

	return preg_replace_callback($expression, function($matches)
	{
		$options = json_decode($matches['json'] ?? '{}', true);

		$parameters = [$matches['code'], $options['default'] ?? null];

		switch ($matches['type'])
		{
			case 'poll' :
				return fenric()->callSharedService('poll', $parameters);
				break;

			case 'banner' :
				return fenric()->callSharedService('banner', $parameters);
				break;

			case 'snippet' :
				return fenric()->callSharedService('snippet', $parameters);
				break;
		}

		return $matches[0];

	}, $value);
}

/**
 * Экранирование строки
 */
function e(string $value = null) : string
{
	return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

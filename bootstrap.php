<?php

/**
 * Установка режима протоколирования ошибок
 */
error_reporting(E_ALL);

/**
 * Установка локали по умолчанию
 */
setlocale(LC_ALL, 'ru_RU.UTF-8');

/**
 * Установка часового пояса по умолчанию
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
		fenric('response')->status(
			\Fenric\Response::STATUS_503
		);

		if (! fenric()->is('production'))
		{
			fenric('request')->isAjax()

			? fenric('response')->json([
				'success' => false,
				'message' => $exception->getMessage(),
				'errfile' => $exception->getFile(),
				'errline' => $exception->getLine(),
			])

			: fenric('response')->view('errors/fatal', [
				'exception' => $exception,
			]);
		}

		fenric('response')->purge()->send();

		exit(1);
	}
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
fenric()->registerSharedService('mail', function(string $resolver = 'default')
{
	$mail = new PHPMailer();

	if (fenric('config::mailing')->get($resolver) instanceof Closure)
	{
		fenric('config::mailing')->get($resolver)->call($mail);
	}

	return $mail;
});

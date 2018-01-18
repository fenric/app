<?php

/**
 * Короткий способ локализации сообщения
 */
function __(string $section, string $message, array $context = []) : string
{
	return fenric()->translate($section, $message, $context);
}

/**
 * Получение IP клиента
 */
function ip()
{
	return fenric('request')->ip();
}

/**
 * Получение текущего URL
 */
function url(array $params = [])
{
	return fenric('request')->url($params);
}

/**
 * Формирование ревизионного адреса статичного файла
 */
function asset(string $location) : string
{
	$fileinfo = fenric()->path('public', $location);

	if ($fileinfo->isFile())
	{
		$location .= '?' . $fileinfo->getMTime();
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
	$expression = '/{#(?<type>[a-z]+):(?<code>[a-zA-Z0-9-\.]{1,255})#}/su';

	return preg_replace_callback($expression, function($matches)
	{
		switch ($matches['type'])
		{
			case 'poll' :
				return fenric()->callSharedService('poll', [$matches['code']]);
				break;

			case 'banner' :
				return fenric()->callSharedService('banner', [$matches['code']]);
				break;

			case 'snippet' :
				return fenric()->callSharedService('snippet', [$matches['code']]);
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

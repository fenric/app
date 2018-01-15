<?php

/**
 * Package
 */
namespace Fenric;

/**
 * Web app
 */
final class App
{

	/**
	 * Запуск приложения
	 */
	public function run() : void
	{
		$this->setTimezone();

		fenric('snippet::system.middleware');
	}

	/**
	 * Установка часового пояса
	 */
	public function setTimezone() : void
	{
		date_default_timezone_set(fenric('parameter::timezone', 'Europe/Moscow'));

		fenric('query')->getPdo()->exec(sprintf('SET @@session.time_zone = "%s";', date('P')));
	}
}

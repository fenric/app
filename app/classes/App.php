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
		fenric('snippet::system.middleware');

		$this->setTimezone();
		$this->tuneSession();

		fenric('event::session.before.start')->run();
		fenric('session')->start(new \SessionHandler());
		fenric('event::session.after.start')->run();

		$this->routing();

		fenric('event::response.before.send')->run();
		fenric('response')->send();
		fenric('event::response.after.send')->run();
	}

	/**
	 * Установка часового пояса
	 */
	public function setTimezone() : void
	{
		date_default_timezone_set(
			fenric('parameter::timezone', 'Europe/Moscow')
		);

		fenric('query')->getPdo()->exec(
			sprintf('SET @@session.time_zone = "%s";', date('P'))
		);
	}

	/**
	 * Настройка механизма сессий
	 */
	public function tuneSession() : void
	{
		ini_set('session.use_cookies', fenric('config::app')
			->get('session.use_cookies', '1')
		);
		ini_set('session.use_only_cookies', fenric('config::app')
			->get('session.use_only_cookies', '1')
		);
		ini_set('session.use_strict_mode', fenric('config::app')
			->get('session.use_strict_mode', '1')
		);
		ini_set('session.use_trans_sid', fenric('config::app')
			->get('session.use_trans_sid', '0')
		);
		ini_set('session.cookie_path', fenric('config::app')
			->get('session.cookie_path', '/')
		);
		ini_set('session.cookie_domain', fenric('config::app')
			->get('session.cookie_domain', '')
		);
		ini_set('session.cookie_secure', fenric('config::app')
			->get('session.cookie_secure', '0')
		);
		ini_set('session.cookie_httponly', fenric('config::app')
			->get('session.cookie_httponly', '0')
		);
		ini_set('session.cookie_lifetime', fenric('config::app')
			->get('session.cookie_lifetime', '0')
		);
		ini_set('session.cache_limiter', fenric('config::app')
			->get('session.cache_limiter', 'nocache')
		);
	}

	/**
	 * Маршрутизация приложения
	 */
	public function routing() : void
	{
		fenric('event::router.running')->subscribe(function($router, $request, $response)
		{
			if (file_exists(fenric()->path('configs', 'routes.php')))
			{
				require_once fenric()->path('configs', 'routes.php');
			}
		});

		fenric('event::router.eavesdropping')->subscribe(function($router, $request, $response, $controller, $match)
		{
			$rule = $match['route'][1];

			if (strcmp(substr($rule, -3), '(/)') === 0)
			{
				if ($controller instanceof \Fenric\Controllers\Abstractable\Abstractable)
				{
					$controller->trailingSlashes();
				}
			}
		});

		fenric('router')->run(fenric('request'), fenric('response'), function($router, $request, $response)
		{
			$view = sprintf('view::errors/http/%d', $response->getStatus());

			$request->isAjax() or $response->setContent(fenric($view)->render());
		});
	}
}

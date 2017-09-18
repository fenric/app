<?php

/**
 * Package
 */
namespace Fenric;

/**
 * Import classes
 */
use Closure;
use SessionHandler;

use Fenric\{
	Controller,
	Request,
	Response,
	Router
};

/**
 * Web app
 */
final class App
{

	/**
	 * Версия приложения
	 */
	const VERSION = '0.9.1-dev';

	/**
	 * Запуск приложения
	 */
	public function run(Closure $middleware)
	{
		$this->setTimezone();

		$this->tuneSession();

		fenric('event::session.before.start')->run();

		fenric('session')->start(new SessionHandler());

		fenric('event::session.after.start')->run();

		$middleware();

		fenric('router')->run(fenric('request'), fenric('response'), function(Router $router, Request $request, Response $response) : void
		{
			$view = sprintf('view::errors/http/%d', $response->getStatus());

			$request->isAjax() or $response->setContent(fenric($view)->render());
		});

		fenric('event::response.before.send')->run();

		fenric('response')->send();

		fenric('event::response.after.send')->run();
	}

	/**
	 * Маршрутизация приложения
	 */
	public function rounting()
	{
		// Главная страница сайта
		fenric('router')->get('/', \Fenric\Controllers\Home::class);

		// Панель управления сайтом
		fenric('router')->scope('/admin', function(Router $router)
		{
			// Главная страница панели управления сайтом
			$router->get('(/)', \Fenric\Controllers\Admin\Index::class, function(Router $router, Request $request, Response $response, Controller $controller) {
				$controller->trailingSlashes();
			});

			// API панели управления сайтом
			$router->scope('/api', function(Router $router)
			{
				// Общее API панели управления сайтом
				$router->any('/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\Admin\Api::class);

				// Управления пользователями
				$router->any('/user/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\Admin\ApiUser::class);

				// Управления разделами
				$router->any('/section/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\Admin\ApiSection::class);

				// Управление публикациями
				$router->any('/publication/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\Admin\ApiPublication::class);

				// Управления тегами
				$router->any('/tag/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\Admin\ApiTag::class);

				// Управление сниппетами
				$router->any('/snippet/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\Admin\ApiSnippet::class);

				// Управление параметрами
				$router->any('/parameter/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\Admin\ApiParameter::class);
			});

			// Обновление системы
			$router->get('/update/', \Fenric\Controllers\Admin\Update::class);
		});

		// Интерфейс пользователя
		fenric('router')->scope('/user', function(Router $router)
		{
			// Общее API пользователя
			$router->any('/api/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\User\Api::class);

			// Регистрация учетной записи
			$router->get('/registration(/)', \Fenric\Controllers\User\Registration::class, function(Router $router, Request $request, Response $response, Controller $controller) {
				$controller->trailingSlashes();
			});
			$router->post('/registration/process(/)', \Fenric\Controllers\User\RegistrationProcess::class, function(Router $router, Request $request, Response $response, Controller $controller) {
				$controller->trailingSlashes();
			});
			$router->get('/registration/<code:[a-z0-9]{40}>(/)', \Fenric\Controllers\User\RegistrationConfirm::class, function(Router $router, Request $request, Response $response, Controller $controller) {
				$controller->trailingSlashes();
			});

			// Аутентификация учетной записи
			$router->get('/login(/)', \Fenric\Controllers\User\Authentication::class, function(Router $router, Request $request, Response $response, Controller $controller) {
				$controller->trailingSlashes();
			});
			$router->post('/login/process(/)', \Fenric\Controllers\User\AuthenticationProcess::class, function(Router $router, Request $request, Response $response, Controller $controller) {
				$controller->trailingSlashes();
			});
			$router->get('/login/<code:[a-z0-9]{40}>(/)', \Fenric\Controllers\User\AuthenticationByToken::class, function(Router $router, Request $request, Response $response, Controller $controller) {
				$controller->trailingSlashes();
			});

			// Создание аутентификационного токена для учетной записи
			$router->get('/login/token/create(/)', \Fenric\Controllers\User\AuthenticationTokenCreate::class, function(Router $router, Request $request, Response $response, Controller $controller) {
				$controller->trailingSlashes();
			});
			$router->post('/login/token/create/process(/)', \Fenric\Controllers\User\AuthenticationTokenCreateProcess::class, function(Router $router, Request $request, Response $response, Controller $controller) {
				$controller->trailingSlashes();
			});

			// Разавторизация учетной записи
			$router->get('/logout(/)', \Fenric\Controllers\User\SignOut::class, function(Router $router, Request $request, Response $response, Controller $controller) {
				$controller->trailingSlashes();
			});

			// Страница с настройками учетной записи
			$router->get('/settings(/)', \Fenric\Controllers\User\ProfileSettings::class, function(Router $router, Request $request, Response $response, Controller $controller) {
				$controller->trailingSlashes();
			});
			$router->post('/settings/save(/)', \Fenric\Controllers\User\ProfileSettingsSave::class, function(Router $router, Request $request, Response $response, Controller $controller) {
				$controller->trailingSlashes();
			});

			// Страница учетной записи
			$router->get('(/<id:[1-9][0-9]*>)(/)', \Fenric\Controllers\User\Profile::class, function(Router $router, Request $request, Response $response, Controller $controller) {
				$controller->trailingSlashes();
			});
		});

		// Поиск по сайту
		fenric('router')->get('/search(/)', \Fenric\Controllers\Search::class, function(Router $router, Request $request, Response $response, Controller $controller) {
			$controller->trailingSlashes();
		});

		// Список тегов
		fenric('router')->get('/tags(/)', \Fenric\Controllers\Tags::class, function(Router $router, Request $request, Response $response, Controller $controller) {
			$controller->trailingSlashes();
		});

		// Список публикаций по тегу
		fenric('router')->get('/tags/<code:[a-z0-9-]+>(/)', \Fenric\Controllers\Tag::class, function(Router $router, Request $request, Response $response, Controller $controller) {
			$controller->trailingSlashes();
		});

		// Страница раздела
		fenric('router')->get('/<code:[a-z0-9-]+>(/)', \Fenric\Controllers\Section::class, function(Router $router, Request $request, Response $response, Controller $controller) {
			$controller->trailingSlashes();
		});

		// Страница публикации
		fenric('router')->get('/<section:[a-z0-9-]+>/<publication:[a-z0-9-]+>(/)', \Fenric\Controllers\Publication::class, function(Router $router, Request $request, Response $response, Controller $controller) {
			$controller->trailingSlashes();
		});

		// Robots.txt
		fenric('router')->get('/robots.txt', \Fenric\Controllers\Services\RobotsTxt::class);

		// Карта сайта
		fenric('router')->get('/sitemap.xml', \Fenric\Controllers\Services\SitemapXml::class);
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
}

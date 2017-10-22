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
	 * Получение информации о релизе
	 */
	public function getReleaseInfo()
	{
		if (is_file(fenric()->path('.', 'release.json')))
		{
			if (is_readable(fenric()->path('.', 'release.json')))
			{
				$content = file_get_contents(
					fenric()->path('.', 'release.json')
				);

				return json_decode($content);
			}
		}
	}

	/**
	 * Запуск приложения
	 */
	public function run(Closure $middleware)
	{
		fenric('snippet::system.middleware');

		$this->setTimezone();
		$this->tuneSession();

		fenric('event::session.before.start')->run();
		fenric('session')->start(new SessionHandler());
		fenric('event::session.after.start')->run();

		$middleware();

		fenric('router')->run(fenric('request'), fenric('response'), function(Router $router, Request $request, Response $response) : void
		{
			$request->isAjax() or $response->setContent(
				fenric(sprintf('view::errors/http/%d', $response->getStatus()))->render()
			);
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
		// Адрес панели управления сайтом
		$admin = fenric('config::app')->get('admin', 'admin');

		// Главная страница сайта
		fenric('router')->get('/', \Fenric\Controllers\Home::class);

		// Панель управления сайтом
		fenric('router')->scope("/{$admin}", function(Router $router)
		{
			// Главная страница панели управления сайтом
			$router->get('(/)', \Fenric\Controllers\Admin\Index::class, function(Router $router, Request $request, Response $response, Controller $controller)
			{
				$controller->trailingSlashes();
			});

			// API панели управления сайтом
			$router->scope('/api', function(Router $router)
			{
				// Общее API панели управления сайтом
				$router->any('/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\Admin\Api::class);

				// Управления пользователями
				$router->any('/user/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', \Fenric\Controllers\Admin\ApiUser::class);
				$router->any('/user/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\Admin\ApiUser::class);

				// Управления разделами
				$router->any('/section/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', \Fenric\Controllers\Admin\ApiSection::class);
				$router->any('/section/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\Admin\ApiSection::class);

				// Управление публикациями
				$router->any('/publication/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', \Fenric\Controllers\Admin\ApiPublication::class);
				$router->any('/publication/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\Admin\ApiPublication::class);

				// Управления тегами
				$router->any('/tag/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', \Fenric\Controllers\Admin\ApiTag::class);
				$router->any('/tag/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\Admin\ApiTag::class);

				// Управление дополнительными полями
				$router->any('/field/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', \Fenric\Controllers\Admin\ApiField::class);
				$router->any('/field/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\Admin\ApiField::class);

				// Управление сниппетами
				$router->any('/snippet/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', \Fenric\Controllers\Admin\ApiSnippet::class);
				$router->any('/snippet/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\Admin\ApiSnippet::class);

				// Управление параметрами
				$router->any('/parameter/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', \Fenric\Controllers\Admin\ApiParameter::class);
				$router->any('/parameter/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\Admin\ApiParameter::class);
			});

			// Обновление системы
			$router->get('/update/', \Fenric\Controllers\Admin\Update::class);
		});

		// Интерфейс пользователя
		fenric('router')->scope('/user', function(Router $router)
		{
			// Страница учетной записи
			$router->get('(/)', \Fenric\Controllers\User\Profile::class, function(Router $router, Request $request, Response $response, Controller $controller)
			{
				$controller->trailingSlashes();
			});

			// Регистрация учетной записи
			$router->get('/registration(/)', \Fenric\Controllers\User\Registration::class, function(Router $router, Request $request, Response $response, Controller $controller)
			{
				$controller->trailingSlashes();
			});
			$router->post('/registration/process(/)', \Fenric\Controllers\User\RegistrationProcess::class, function(Router $router, Request $request, Response $response, Controller $controller)
			{
				$controller->trailingSlashes();
			});
			$router->get('/registration/<code:[a-z0-9]{40}>(/)', \Fenric\Controllers\User\RegistrationConfirm::class, function(Router $router, Request $request, Response $response, Controller $controller)
			{
				$controller->trailingSlashes();
			});

			// Аутентификация учетной записи
			$router->get('/login(/)', \Fenric\Controllers\User\Authentication::class, function(Router $router, Request $request, Response $response, Controller $controller)
			{
				$controller->trailingSlashes();
			});
			$router->post('/login/process(/)', \Fenric\Controllers\User\AuthenticationProcess::class, function(Router $router, Request $request, Response $response, Controller $controller)
			{
				$controller->trailingSlashes();
			});
			$router->get('/login/<code:[a-z0-9]{40}>(/)', \Fenric\Controllers\User\AuthenticationByToken::class, function(Router $router, Request $request, Response $response, Controller $controller)
			{
				$controller->trailingSlashes();
			});

			// Создание аутентификационного токена для учетной записи
			$router->get('/login/token/create(/)', \Fenric\Controllers\User\AuthenticationTokenCreate::class, function(Router $router, Request $request, Response $response, Controller $controller)
			{
				$controller->trailingSlashes();
			});
			$router->post('/login/token/create/process(/)', \Fenric\Controllers\User\AuthenticationTokenCreateProcess::class, function(Router $router, Request $request, Response $response, Controller $controller)
			{
				$controller->trailingSlashes();
			});

			// Разавторизация учетной записи
			$router->get('/logout(/)', \Fenric\Controllers\User\SignOut::class, function(Router $router, Request $request, Response $response, Controller $controller)
			{
				$controller->trailingSlashes();
			});

			// Страница с настройками учетной записи
			$router->get('/settings(/)', \Fenric\Controllers\User\ProfileSettings::class, function(Router $router, Request $request, Response $response, Controller $controller)
			{
				$controller->trailingSlashes();
			});
			$router->post('/settings/save(/)', \Fenric\Controllers\User\ProfileSettingsSave::class, function(Router $router, Request $request, Response $response, Controller $controller)
			{
				$controller->trailingSlashes();
			});

			// Общее API пользователя
			$router->any('/api/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\User\Api::class);
		});

		// Поиск по сайту
		fenric('router')->get('/search(/)', \Fenric\Controllers\Search::class, function(Router $router, Request $request, Response $response, Controller $controller)
		{
			$controller->trailingSlashes();
		});

		// Список пользователей
		fenric('router')->get('/users(/)', \Fenric\Controllers\Users::class, function(Router $router, Request $request, Response $response, Controller $controller)
		{
			$controller->trailingSlashes();
		});

		// Страница пользователя
		fenric('router')->get('/users/<id:[1-9][0-9]{0,10}>(/)', \Fenric\Controllers\User::class, function(Router $router, Request $request, Response $response, Controller $controller)
		{
			$controller->trailingSlashes();
		});

		// Страница раздела
		fenric('router')->get('/<section:[a-z0-9-]{1,255}>(/<tag:[a-z0-9-]{1,255}>)(/)', \Fenric\Controllers\Section::class, function(Router $router, Request $request, Response $response, Controller $controller)
		{
			$controller->trailingSlashes();
		});

		// Страница публикации
		fenric('router')->get('/<section:[a-z0-9-]{1,255}>/<publication:[a-z0-9-]{1,255}>.html', \Fenric\Controllers\Publication::class, function(Router $router, Request $request, Response $response, Controller $controller)
		{
			// @continue
		});

		// Сервисы
		fenric('router')->get('/robots.txt', \Fenric\Controllers\Services\RobotsTxt::class);
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

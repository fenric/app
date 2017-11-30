<?php

/**
 * Главная страница сайта
 */
fenric('router')->get('/', \Fenric\Controllers\Home::class);

/**
 * Панель управления сайтом
 */
fenric('router')->scope(fenric('config::app')->get('admin', 'admin'), function($router)
{
	/**
	 * Главная страница панели управления сайтом
	 */
	$router->get('(/)', \Fenric\Controllers\Admin\Index::class, function($router, $request, $response, $controller)
	{
		$controller->trailingSlashes();
	});

	/**
	 * API панели управления сайтом
	 */
	$router->scope('/api', function($router)
	{
		/**
		 * Общее API панели управления сайтом
		 */
		$router->any('/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\Admin\Api::class);

		/**
		 * Управления пользователями
		 */
		$router->any('/user/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', \Fenric\Controllers\Admin\ApiUser::class);
		$router->any('/user/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\Admin\ApiUser::class);

		/**
		 * Управления разделами
		 */
		$router->any('/section/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', \Fenric\Controllers\Admin\ApiSection::class);
		$router->any('/section/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\Admin\ApiSection::class);

		/**
		 * Управление публикациями
		 */
		$router->any('/publication/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', \Fenric\Controllers\Admin\ApiPublication::class);
		$router->any('/publication/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\Admin\ApiPublication::class);

		/**
		 * Управления тегами
		 */
		$router->any('/tag/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', \Fenric\Controllers\Admin\ApiTag::class);
		$router->any('/tag/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\Admin\ApiTag::class);

		/**
		 * Управление дополнительными полями
		 */
		$router->any('/field/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', \Fenric\Controllers\Admin\ApiField::class);
		$router->any('/field/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\Admin\ApiField::class);

		/**
		 * Управление сниппетами
		 */
		$router->any('/snippet/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', \Fenric\Controllers\Admin\ApiSnippet::class);
		$router->any('/snippet/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\Admin\ApiSnippet::class);

		/**
		 * Управление опросами
		 */
		$router->any('/poll/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', \Fenric\Controllers\Admin\ApiPoll::class);
		$router->any('/poll/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\Admin\ApiPoll::class);

		/**
		 * Управление баннерами
		 */
		$router->any('/banner/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', \Fenric\Controllers\Admin\ApiBanner::class);
		$router->any('/banner/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\Admin\ApiBanner::class);

		/**
		 * Управление радио
		 */
		$router->any('/radio/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', \Fenric\Controllers\Admin\ApiRadio::class);
		$router->any('/radio/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\Admin\ApiRadio::class);

		/**
		 * Управление параметрами
		 */
		$router->any('/parameter/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', \Fenric\Controllers\Admin\ApiParameter::class);
		$router->any('/parameter/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\Admin\ApiParameter::class);
	});

	/**
	 * Обновление системы
	 */
	$router->get('/update/', \Fenric\Controllers\Admin\Update::class);
});

/**
 * Интерфейс пользователя
 */
fenric('router')->scope('/user', function($router)
{
	/**
	 * Страница учетной записи
	 */
	$router->get('(/)', \Fenric\Controllers\User\Profile::class, function($router, $request, $response, $controller)
	{
		$controller->trailingSlashes();
	});

	/**
	 * Регистрация учетной записи
	 */
	$router->get('/registration(/)', \Fenric\Controllers\User\Registration::class, function($router, $request, $response, $controller)
	{
		$controller->trailingSlashes();
	});
	$router->post('/registration/process(/)', \Fenric\Controllers\User\RegistrationProcess::class, function($router, $request, $response, $controller)
	{
		$controller->trailingSlashes();
	});
	$router->get('/registration/<code:[a-z0-9]{40}>(/)', \Fenric\Controllers\User\RegistrationConfirm::class, function($router, $request, $response, $controller)
	{
		$controller->trailingSlashes();
	});

	/**
	 * Аутентификация учетной записи
	 */
	$router->get('/login(/)', \Fenric\Controllers\User\Authentication::class, function($router, $request, $response, $controller)
	{
		$controller->trailingSlashes();
	});
	$router->post('/login/process(/)', \Fenric\Controllers\User\AuthenticationProcess::class, function($router, $request, $response, $controller)
	{
		$controller->trailingSlashes();
	});
	$router->get('/login/<code:[a-z0-9]{40}>(/)', \Fenric\Controllers\User\AuthenticationByToken::class, function($router, $request, $response, $controller)
	{
		$controller->trailingSlashes();
	});

	/**
	 * Создание аутентификационного токена для учетной записи
	 */
	$router->get('/login/token/create(/)', \Fenric\Controllers\User\AuthenticationTokenCreate::class, function($router, $request, $response, $controller)
	{
		$controller->trailingSlashes();
	});
	$router->post('/login/token/create/process(/)', \Fenric\Controllers\User\AuthenticationTokenCreateProcess::class, function($router, $request, $response, $controller)
	{
		$controller->trailingSlashes();
	});

	/**
	 * Разавторизация учетной записи
	 */
	$router->get('/logout(/)', \Fenric\Controllers\User\SignOut::class, function($router, $request, $response, $controller)
	{
		$controller->trailingSlashes();
	});

	/**
	 * Страница с настройками учетной записи
	 */
	$router->get('/settings(/)', \Fenric\Controllers\User\ProfileSettings::class, function($router, $request, $response, $controller)
	{
		$controller->trailingSlashes();
	});
	$router->post('/settings/save(/)', \Fenric\Controllers\User\ProfileSettingsSave::class, function($router, $request, $response, $controller)
	{
		$controller->trailingSlashes();
	});

	/**
	 * Общее API пользователя
	 */
	$router->any('/api/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\User\Api::class);
});

/**
 * Общее API сайта
 */
fenric('router')->any('/api/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\Api::class);
fenric('router')->any('/api/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', \Fenric\Controllers\Api::class);

/**
 * Управление комментариями
 */
fenric('router')->any('/api/comment/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', \Fenric\Controllers\ApiComment::class);
fenric('router')->any('/api/comment/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\ApiComment::class);

/**
 * Управление опросами
 */
fenric('router')->any('/api/poll/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', \Fenric\Controllers\ApiPoll::class);
fenric('router')->any('/api/poll/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\ApiPoll::class);

/**
 * Регистрация клика по баннеру
 */
fenric('router')->get('/click/<id:[1-9][0-9]{0,10}>(/)', \Fenric\Controllers\Banner::class, function($router, $request, $response, $controller)
{
	$controller->trailingSlashes();
});

/**
 * Поиск по сайту
 */
fenric('router')->get('/search(/)', \Fenric\Controllers\Search::class, function($router, $request, $response, $controller)
{
	$controller->trailingSlashes();
});

/**
 * Список тегов
 */
fenric('router')->get('/tags(/)', \Fenric\Controllers\Tags::class, function($router, $request, $response, $controller)
{
	$controller->trailingSlashes();
});

/**
 * Список публикаций тега
 */
fenric('router')->get('/tags/<code:[a-z0-9-]+>(/)', \Fenric\Controllers\Tag::class, function($router, $request, $response, $controller)
{
	$controller->trailingSlashes();
});

/**
 * Список пользователей
 */
fenric('router')->get('/users(/)', \Fenric\Controllers\Users::class, function($router, $request, $response, $controller)
{
	$controller->trailingSlashes();
});

/**
 * Страница пользователя
 */
fenric('router')->get('/users/<id:[1-9][0-9]{0,10}>(/)', \Fenric\Controllers\User::class, function($router, $request, $response, $controller)
{
	$controller->trailingSlashes();
});

/**
 * Страница раздела
 */
fenric('router')->get('/<section:[a-z0-9-]{1,255}>(/<tag:[a-z0-9-]{1,255}>)(/)', \Fenric\Controllers\Section::class, function($router, $request, $response, $controller)
{
	$controller->trailingSlashes();
});

/**
 * Страница публикации
 */
fenric('router')->get('/<section:[a-z0-9-]{1,255}>/<publication:[a-z0-9-]{1,255}>.html', \Fenric\Controllers\Publication::class, function($router, $request, $response, $controller)
{
	// @continue
});

/**
 * Сервисы
 */
fenric('router')->get('/robots.txt', \Fenric\Controllers\Services\RobotsTxt::class);
fenric('router')->get('/sitemap.xml', \Fenric\Controllers\Services\SitemapXml::class);

/**
 * Псевдо JavaScript файл с системными данными
 */
fenric('router')->any('/assets/fenric.js', \Fenric\Controllers\Assets\FenricJs::class);

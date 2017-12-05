<?php

/**
 * Главная страница сайта
 */
fenric('router')->get('/', \Fenric\Controllers\Home::class);

/**
 * Панель управления сайтом
 */
fenric('router')->scope('/admin', function($router)
{
	$router->get('(/)', \Fenric\Controllers\Admin\Index::class);
	$router->get('/update/', \Fenric\Controllers\Admin\Update::class);

	$router->any('/api/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\Admin\Api::class);

	$router->any('/api/user/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', \Fenric\Controllers\Admin\ApiUser::class);
	$router->any('/api/user/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\Admin\ApiUser::class);

	$router->any('/api/section/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', \Fenric\Controllers\Admin\ApiSection::class);
	$router->any('/api/section/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\Admin\ApiSection::class);

	$router->any('/api/publication/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', \Fenric\Controllers\Admin\ApiPublication::class);
	$router->any('/api/publication/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\Admin\ApiPublication::class);

	$router->any('/api/tag/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', \Fenric\Controllers\Admin\ApiTag::class);
	$router->any('/api/tag/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\Admin\ApiTag::class);

	$router->any('/api/field/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', \Fenric\Controllers\Admin\ApiField::class);
	$router->any('/api/field/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\Admin\ApiField::class);

	$router->any('/api/snippet/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', \Fenric\Controllers\Admin\ApiSnippet::class);
	$router->any('/api/snippet/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\Admin\ApiSnippet::class);

	$router->any('/api/poll/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', \Fenric\Controllers\Admin\ApiPoll::class);
	$router->any('/api/poll/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\Admin\ApiPoll::class);

	$router->any('/api/banner/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', \Fenric\Controllers\Admin\ApiBanner::class);
	$router->any('/api/banner/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\Admin\ApiBanner::class);

	$router->any('/api/radio/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', \Fenric\Controllers\Admin\ApiRadio::class);
	$router->any('/api/radio/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\Admin\ApiRadio::class);

	$router->any('/api/parameter/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', \Fenric\Controllers\Admin\ApiParameter::class);
	$router->any('/api/parameter/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\Admin\ApiParameter::class);

});

/**
 * Интерфейс пользователя
 */
fenric('router')->scope('/user', function($router)
{
	$router->get('(/)', \Fenric\Controllers\User\Profile::class);

	$router->get('/registration(/)', \Fenric\Controllers\User\Registration::class);
	$router->post('/registration/process(/)', \Fenric\Controllers\User\RegistrationProcess::class);
	$router->get('/registration/<code:[a-z0-9]{40}>(/)', \Fenric\Controllers\User\RegistrationConfirm::class);

	$router->get('/login(/)', \Fenric\Controllers\User\Authentication::class);
	$router->post('/login/process(/)', \Fenric\Controllers\User\AuthenticationProcess::class);
	$router->get('/login/<code:[a-z0-9]{40}>(/)', \Fenric\Controllers\User\AuthenticationByToken::class);

	$router->get('/login/token/create(/)', \Fenric\Controllers\User\AuthenticationTokenCreate::class);
	$router->post('/login/token/create/process(/)', \Fenric\Controllers\User\AuthenticationTokenCreateProcess::class);

	$router->get('/logout(/)', \Fenric\Controllers\User\SignOut::class);

	$router->get('/settings(/)', \Fenric\Controllers\User\ProfileSettings::class);
	$router->post('/settings/save(/)', \Fenric\Controllers\User\ProfileSettingsSave::class);

	$router->any('/api/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\User\Api::class);
});

/**
 * API сайта
 */
fenric('router')->scope('/api', function($router)
{
	$router->any('/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\Api::class);
	$router->any('/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', \Fenric\Controllers\Api::class);

	$router->any('/comment/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', \Fenric\Controllers\ApiComment::class);
	$router->any('/comment/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\ApiComment::class);

	$router->any('/poll/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', \Fenric\Controllers\ApiPoll::class);
	$router->any('/poll/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', \Fenric\Controllers\ApiPoll::class);
});

/**
 * Регистрация клика по баннеру
 */
fenric('router')->get('/click/<id:[1-9][0-9]{0,10}>(/)', \Fenric\Controllers\Banner::class);

/**
 * Поиск по сайту
 */
fenric('router')->get('/search(/)', \Fenric\Controllers\Search::class);

/**
 * Список тегов
 */
fenric('router')->get('/tags(/)', \Fenric\Controllers\Tags::class);

/**
 * Список публикаций тега
 */
fenric('router')->get('/tags/<code:[a-z0-9-]+>(/)', \Fenric\Controllers\Tag::class);

/**
 * Список пользователей
 */
fenric('router')->get('/users(/)', \Fenric\Controllers\Users::class);

/**
 * Страница пользователя
 */
fenric('router')->get('/users/<id:[1-9][0-9]{0,10}>(/)', \Fenric\Controllers\User::class);

/**
 * Страница раздела
 */
fenric('router')->get('/<section:[a-z0-9-]{1,255}>(/<tag:[a-z0-9-]{1,255}>)(/)', \Fenric\Controllers\Section::class);

/**
 * Страница публикации
 */
fenric('router')->get('/<section:[a-z0-9-]{1,255}>/<publication:[a-z0-9-]{1,255}>.html', \Fenric\Controllers\Publication::class);

/**
 * Sitemap.xml
 */
fenric('router')->get('/sitemap.xml', \Fenric\Controllers\Sitemap::class);

/**
 * humans.txt
 */
fenric('router')->get('/humans.txt', \Fenric\Controllers\Blank::class, function($router, $request, $response, $controller)
{
	$response->setStatus(200);
	$response->setHeader('Content-type: text/plain; charset=UTF-8');
	$response->setContent(fenric('parameter::humans.txt') ?: '');
});

/**
 * robots.txt
 */
fenric('router')->get('/robots.txt', \Fenric\Controllers\Blank::class, function($router, $request, $response, $controller)
{
	$response->setStatus(200);
	$response->setHeader('Content-type: text/plain; charset=UTF-8');
	$response->setContent(fenric('parameter::robots.txt') ?: '');
});

/**
 * JavaScript файл с системными данными
 */
fenric('router')->any('/assets/fenric.js', \Fenric\Controllers\Blank::class, function($router, $request, $response, $controller)
{
	$response->setStatus(200);
	$response->setHeader('Content-Type: application/javascript; charset=UTF-8');
	$response->setContent(fenric('view::assets/fenric.js')->render());
});

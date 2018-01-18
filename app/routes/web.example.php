<?php

// Шаблоны параметров маршрутов
$this->pattern('id', '[1-9][0-9]{0,10}');
$this->pattern('action', '[a-z][a-z0-9-]*');

// Главная страница сайта
$this->home('Home');

// Панель управления сайтом
$this->group(function()
{
	$this->prefix('/admin');
	$this->namespace('Admin\\');

	// Рабочий стол
	$this->get('(/)', 'Desktop');

	// Обновление проекта (deploy)
	$this->get('/update(/)', 'Update');

	// API панели управления сайтом
	$this->group(function()
	{
		$this->prefix('/api');

		// Основное API панели управления сайтом
		$this->any('/<action>/(<id>/)', 'Api');

		// API для управления пользователями
		$this->any('/user/<id>/<action>/', 'ApiUser');
		$this->any('/user/<action>/(<id>/)', 'ApiUser');

		// API для управления разделами
		$this->any('/section/<id>/<action>/', 'ApiSection');
		$this->any('/section/<action>/(<id>/)', 'ApiSection');

		// API для управления публикациями
		$this->any('/publication/<id>/<action>/', 'ApiPublication');
		$this->any('/publication/<action>/(<id>/)', 'ApiPublication');

		// API для управления тегами
		$this->any('/tag/<id>/<action>/', 'ApiTag');
		$this->any('/tag/<action>/(<id>/)', 'ApiTag');

		// API для управления дополнительными полями
		$this->any('/field/<id>/<action>/', 'ApiField');
		$this->any('/field/<action>/(<id>/)', 'ApiField');

		// API для управления сниппетами
		$this->any('/snippet/<id>/<action>/', 'ApiSnippet');
		$this->any('/snippet/<action>/(<id>/)', 'ApiSnippet');

		// API для управления опросами
		$this->any('/poll/<id>/<action>/', 'ApiPoll');
		$this->any('/poll/<action>/(<id>/)', 'ApiPoll');

		// API для управления баннерами
		$this->any('/banner/<id>/<action>/', 'ApiBanner');
		$this->any('/banner/<action>/(<id>/)', 'ApiBanner');

		// API для управления радиостанциями
		$this->any('/radio/<id>/<action>/', 'ApiRadio');
		$this->any('/radio/<action>/(<id>/)', 'ApiRadio');

		// API для управления параметрами
		$this->any('/parameter/<id>/<action>/', 'ApiParameter');
		$this->any('/parameter/<action>/(<id>/)', 'ApiParameter');
	});
});

// Пользовательская часть сайта
$this->group(function()
{
	$this->prefix('/user');
	$this->namespace('User\\');

	// Профайл
	$this->get('(/)', 'Profile');

	// Регистрация пользователя
	$this->get('/registration(/)', 'Registration');
	$this->post('/registration/process(/)', 'RegistrationProcess');
	$this->get('/registration/<code:[a-z0-9]{40}>(/)', 'RegistrationConfirm');

	// Авторизация пользователя
	$this->get('/login(/)', 'Authentication');
	$this->post('/login/process(/)', 'AuthenticationProcess');

	// Авторизация пользователя по токену
	$this->get('/login/token/create(/)', 'AuthenticationTokenCreate');
	$this->post('/login/token/create/process(/)', 'AuthenticationTokenCreateProcess');
	$this->get('/login/<code:[a-z0-9]{40}>(/)', 'AuthenticationByToken');

	// Разавторизация пользователя
	$this->get('/logout(/)', 'SignOut');

	// Пользовательские настройки
	$this->get('/settings(/)', 'ProfileSettings');
	$this->post('/settings/save(/)', 'ProfileSettingsSave');

	// Пользовательское API
	$this->any('/api/<action>/(<id>/)', 'Api');
});

//
//
//

$this->any('/api/<action>/(<id>/)', 'Api');
$this->any('/api/<id>/<action>/', 'Api');

$this->any('/api/comment/<id>/<action>/', 'ApiComment');
$this->any('/api/comment/<action>/(<id>/)', 'ApiComment');

$this->any('/api/poll/<id>/<action>/', 'ApiPoll');
$this->any('/api/poll/<action>/(<id>/)', 'ApiPoll');

$this->get('/ad/<id>(/)', 'Banner');

$this->get('/search(/)', 'Search');

$this->get('/tags(/)', 'Tags');
$this->get('/tags/<code:[a-z0-9-]+>(/)', 'Tag');

$this->get('/users(/)', 'Users');
$this->get('/users/<id>(/)', 'User');

$this->get('/<section:[a-z0-9-]{1,255}>(/<tag:[a-z0-9-]{1,255}>)(/)', 'Section');
$this->get('/<section:[a-z0-9-]{1,255}>/<publication:[a-z0-9-]{1,255}>.html', 'Publication');

$this->get('/sitemap.xml', 'Sitemap');

$this->get('/humans.txt', function($req, $res) {
	$res->header('Content-type', 'text/plain; charset=UTF-8');
	$res->content(fenric('parameter::humans.txt'));
});

$this->get('/robots.txt', function($req, $res) {
	$res->header('Content-type', 'text/plain; charset=UTF-8');
	$res->content(fenric('parameter::robots.txt'));
});

$this->get('/assets/fenric.js', function($req, $res) {
	$res->view('assets/fenric.js');
	$res->header('Content-Type', 'application/javascript; charset=UTF-8');
});

// Контроллер по умолчанию
$this->default(function($req, $res)
{
	$res->isOk() and $res->status(
		$res::STATUS_404
	);

	if (! ($req->isAjax() || $res->isInformation())) {
		$res->view(sprintf('errors/http/%d', $res->getStatusCode()));
	}
});

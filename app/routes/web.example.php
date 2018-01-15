<?php

$this->home('Home');

$this->get('/admin(/)', 'Admin\Desktop');
$this->get('/admin/update(/)', 'Admin\Update');

$this->any('/admin/api/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', 'Admin\Api');

$this->crud('/admin/api/user/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', 'Admin\ApiUser');
$this->crud('/admin/api/user/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', 'Admin\ApiUser');

$this->crud('/admin/api/section/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', 'Admin\ApiSection');
$this->crud('/admin/api/section/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', 'Admin\ApiSection');

$this->crud('/admin/api/publication/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', 'Admin\ApiPublication');
$this->crud('/admin/api/publication/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', 'Admin\ApiPublication');

$this->crud('/admin/api/tag/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', 'Admin\ApiTag');
$this->crud('/admin/api/tag/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', 'Admin\ApiTag');

$this->crud('/admin/api/field/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', 'Admin\ApiField');
$this->crud('/admin/api/field/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', 'Admin\ApiField');

$this->crud('/admin/api/snippet/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', 'Admin\ApiSnippet');
$this->crud('/admin/api/snippet/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', 'Admin\ApiSnippet');

$this->crud('/admin/api/poll/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', 'Admin\ApiPoll');
$this->crud('/admin/api/poll/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', 'Admin\ApiPoll');

$this->crud('/admin/api/banner/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', 'Admin\ApiBanner');
$this->crud('/admin/api/banner/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', 'Admin\ApiBanner');

$this->crud('/admin/api/radio/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', 'Admin\ApiRadio');
$this->crud('/admin/api/radio/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', 'Admin\ApiRadio');

$this->crud('/admin/api/parameter/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', 'Admin\ApiParameter');
$this->crud('/admin/api/parameter/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', 'Admin\ApiParameter');

$this->get('/user(/)', 'User\Profile');

$this->get('/user/registration(/)', 'User\Registration');
$this->post('/user/registration/process(/)', 'User\RegistrationProcess');
$this->get('/user/registration/<code:[a-z0-9]{40}>(/)', 'User\RegistrationConfirm');

$this->get('/user/login(/)', 'User\Authentication');
$this->post('/user/login/process(/)', 'User\AuthenticationProcess');

$this->get('/user/login/<code:[a-z0-9]{40}>(/)', 'User\AuthenticationTokenCreate');
$this->get('/user/login/token/create(/)', 'User\AuthenticationByToken');
$this->post('/user/login/token/create/process(/)', 'User\AuthenticationTokenCreateProcess');

$this->get('/user/logout(/)', 'User\SignOut');

$this->get('/user/settings(/)', 'User\ProfileSettings');
$this->post('/user/settings/save(/)', 'User\ProfileSettingsSave');

$this->any('/user/api/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', 'User\Api');

$this->any('/api/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', 'Api');
$this->any('/api/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', 'Api');

$this->any('/api/comment/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', 'ApiComment');
$this->any('/api/comment/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', 'ApiComment');

$this->any('/api/poll/<id:[1-9][0-9]{0,10}>/<action:[a-z][a-z0-9-]*>/', 'ApiPoll');
$this->any('/api/poll/<action:[a-z][a-z0-9-]*>/(<id:[1-9][0-9]{0,10}>/)', 'ApiPoll');

$this->get('/ad/<id:[1-9][0-9]{0,10}>(/)', 'Banner');

$this->get('/search(/)', 'Search');

$this->get('/tags(/)', 'Tags');
$this->get('/tags/<code:[a-z0-9-]+>(/)', 'Tag');

$this->get('/users(/)', 'Users');
$this->get('/users/<id:[1-9][0-9]{0,10}>(/)', 'User');

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

$this->fallback(function($req, $res)
{
	if ($res->isOk())
	{
		$res->status($res::STATUS_404);
	}

	if (! ($req->isAjax() || $res->isInformational()))
	{
		$res->view(sprintf('errors/http/%d', $res->getStatusCode()));
	}
});

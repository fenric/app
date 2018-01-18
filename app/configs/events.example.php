<?php

$events['response.before.send'] = [
	Fenric\Events\ResponseBeforeSend::class,
];

$events['response.after.send'] = [
	Fenric\Events\ResponseAfterSend::class,
];

$events['router.api.middleware'] = [
	Fenric\Events\RouterApiMiddleware::class,
];

$events['router.web.middleware'] = [
	Fenric\Events\RouterWebMiddleware::class,
];

$events['session.before.start'] = [
	Fenric\Events\SessionBeforeStart::class,
];

$events['session.after.start'] = [
	Fenric\Events\SessionAfterStart::class,
];

$events['session.before.restart'] = [
	Fenric\Events\SessionBeforeRestart::class,
];

$events['session.after.restart'] = [
	Fenric\Events\SessionAfterRestart::class,
];

$events['session.before.destroy'] = [
	Fenric\Events\SessionBeforeDestroy::class,
];

$events['session.after.destroy'] = [
	Fenric\Events\SessionAfterDestroy::class,
];

$events['session.before.close'] = [
	Fenric\Events\SessionBeforeClose::class,
];

$events['session.after.close'] = [
	Fenric\Events\SessionAfterClose::class,
];

$events['model.user.post.insert'] = [
	Fenric\Events\ModelUserPostInsert::class,
];

$events['model.user.token.create'] = [
	Fenric\Events\ModelUserTokenCreate::class,
];

return $events;

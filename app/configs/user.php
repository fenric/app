<?php

$options = [];

$options['adulthood'] = 18;

$options['registration.enabled'] = true;
$options['authentication.enabled'] = true;

$options['roles']['administrator']['name'] = __('user', 'role.administrator.name');
$options['roles']['administrator']['accesses']['desktop'] = true;
$options['roles']['administrator']['accesses']['upload.images'] = true;
$options['roles']['administrator']['accesses']['upload.audios'] = true;
$options['roles']['administrator']['accesses']['upload.videos'] = true;
$options['roles']['administrator']['accesses']['upload.pdf'] = true;

$options['roles']['redactor']['name'] = __('user', 'role.redactor.name');
$options['roles']['redactor']['accesses']['desktop'] = true;
$options['roles']['redactor']['accesses']['upload.images'] = true;
$options['roles']['redactor']['accesses']['upload.audios'] = true;
$options['roles']['redactor']['accesses']['upload.videos'] = true;
$options['roles']['redactor']['accesses']['upload.pdf'] = true;

$options['roles']['moderator']['name'] = __('user', 'role.moderator.name');
$options['roles']['moderator']['accesses']['desktop'] = false;
$options['roles']['moderator']['accesses']['upload.images'] = true;
$options['roles']['moderator']['accesses']['upload.audios'] = false;
$options['roles']['moderator']['accesses']['upload.videos'] = false;
$options['roles']['moderator']['accesses']['upload.pdf'] = false;

$options['roles']['user']['name'] = __('user', 'role.user.name');
$options['roles']['user']['accesses']['desktop'] = false;
$options['roles']['user']['accesses']['upload.images'] = true;
$options['roles']['user']['accesses']['upload.audios'] = false;
$options['roles']['user']['accesses']['upload.videos'] = false;
$options['roles']['user']['accesses']['upload.pdf'] = false;

return $options;

<?php

$options = [];

$options['adulthood'] = 18;

$options['registration.enabled'] = true;
$options['authentication.enabled'] = true;

$options['roles']['administrator']['name'] = fenric()->t('user', 'role.administrator.name');
$options['roles']['administrator']['accesses']['desktop'] = true;
$options['roles']['administrator']['accesses']['upload.documents'] = true;
$options['roles']['administrator']['accesses']['upload.images'] = true;
$options['roles']['administrator']['accesses']['upload.pdf'] = true;

$options['roles']['redactor']['name'] = fenric()->t('user', 'role.redactor.name');
$options['roles']['redactor']['accesses']['desktop'] = false;
$options['roles']['redactor']['accesses']['upload.documents'] = true;
$options['roles']['redactor']['accesses']['upload.images'] = true;
$options['roles']['redactor']['accesses']['upload.pdf'] = true;

$options['roles']['moderator']['name'] = fenric()->t('user', 'role.moderator.name');
$options['roles']['moderator']['accesses']['desktop'] = false;
$options['roles']['moderator']['accesses']['upload.documents'] = false;
$options['roles']['moderator']['accesses']['upload.images'] = true;
$options['roles']['moderator']['accesses']['upload.pdf'] = false;

$options['roles']['user']['name'] = fenric()->t('user', 'role.user.name');
$options['roles']['user']['accesses']['desktop'] = false;
$options['roles']['user']['accesses']['upload.documents'] = false;
$options['roles']['user']['accesses']['upload.images'] = true;
$options['roles']['user']['accesses']['upload.pdf'] = false;

return $options;

<?php

/**
 * @link http://php.net/manual/session.configuration.php
 */

$options = [];

$options['use_cookies'] = true;
$options['use_only_cookies'] = true;
$options['use_strict_mode'] = true;
$options['use_trans_sid'] = false;
$options['cookie_path'] = '/';
$options['cookie_domain'] = '';
$options['cookie_secure'] = false;
$options['cookie_httponly'] = false;
$options['cookie_lifetime'] = false;
$options['cache_limiter'] = 'nocache';

return $options;

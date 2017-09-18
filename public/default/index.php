<?php

/**
 * Загрузка приложения
 */
require_once '../../vendor/autoload.php';

/**
 * Запуск приложения
 */
fenric('app')->run(function()
{
	fenric('app')->rounting();
});

<?php

/**
 * Сборка приложения
 */
require_once '../vendor/autoload.php';

/**
 * Запуск приложения
 */
fenric('app')->run();

/**
 * Запуск сессии
 */
fenric('request')->session->start();

/**
 * Запуск маршрутизатора
 */
fenric('router')->map()->run();

/**
 * Отправка ответа клиенту
 */
fenric('response')->send();

/**
 * Завершение работы
 */
exit(0);

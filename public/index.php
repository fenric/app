<?php

/**
 * Загрузка приложения
 */
require_once '../bootstrap.php';

/**
 * Запуск приложения
 */
fenric('app')->run();

/**
 * Запуск сессии
 */
fenric('request')->session->start(new SessionHandler());

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

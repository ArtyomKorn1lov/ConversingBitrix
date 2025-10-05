<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * Автозагрузка классов psr-4
*/
if (
    is_file(__DIR__ . '/vendor/autoload.php')
    && !defined('COMPOSER_INITIALIZED')
) {
    require_once __DIR__ . '/vendor/autoload.php';
    @define('COMPOSER_INITIALIZED', true);
}

/**
 * Неймспейсы контроллеров
 */
$controllerNamespaces = [
    "Visit"
];

/**
 * Регистрация контроллеров
*/
foreach ($controllerNamespaces as $entity) {
    $controller = '\\Conversing\\Controllers\\' . $entity . '\\' . $entity . 'Controller';
    if (class_exists('\\Conversing\\Controllers\\' . $entity . '\\' . $entity . 'Controller')) {
        @class_alias($controller, '\\Conversing\\RestControllers\\' . $entity);
    }
}

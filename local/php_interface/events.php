<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Application;
use Conversing\Statistic\Service;

/**
 * Регистрация Обработчиков событий
 */
$eventManager = Bitrix\Main\EventManager::getInstance();

$eventManager->addEventHandler(
    "main",
    "OnAfterEpilog",
    ['PageHandler', 'onAfterEpilog']
);

class PageHandler {

    public static function onAfterEpilog(): void {
        if (!Application::getInstance()->getContext()->getRequest()->isAjaxRequest()) {
            global $APPLICATION;
            Service::$params = [
                "title" => $APPLICATION->GetTitle(),
                "description" => $APPLICATION->GetProperty("description"),
                "keywords" => $APPLICATION->GetProperty("keywords"),
                "robots" => $APPLICATION->GetProperty("robots"),
                "curPageURL" => $APPLICATION->GetCurPage(),
                'curPage' => $APPLICATION->GetCurPage(false),
            ];
        }
        $obj = new Service(false, Service::$params, Service::$params['curPage']);
    }
}
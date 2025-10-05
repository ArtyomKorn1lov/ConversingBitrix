<?php

namespace Conversing\Statistic;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\Context;
use Bitrix\Main\SystemException;
use CGuest;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\Web\Json;

use Conversing\Constants;
use Conversing\Helpers\Data;

class Service
{
    public static array $params = [];
    private array $fields = [];
    private int $visitorId;
    private array $visitorData = [];
    private bool $portraitIsComplete = false;

    public function __construct(array $params = null, string|bool $curPage = false, bool $isAddAction = false)
    {
        try {
            $this->setVisitorUnicId();
            if ($isAddAction) {
                return;
            }
            if ($this->checkTestingPage($curPage)) {
                $visitorData = $this->getVisitorData();
                $this->setVisitorsParams($visitorData);
                $this->saveVisitorPortrait();
                $this->portraitIsComplete = true;
                return;
            }
            $this->addStatisticFields($params);
            $this->addVisitorPageData();
        } catch (SystemException $exception) {
            AddMessage2Log($exception->getMessage(), "module.conversing");
        }
    }

    /**
     * @throws SystemException
     */
    protected function setVisitorUnicId(): void
    {
        $context = Context::getCurrent();
        $request = $context->getRequest();
        $cookie = $request->getCookie('GUEST_ID');
        if (empty($cookie)) {
            throw new SystemException("ID уникального посетителя не найден");
        }
        $this->visitorId = (int)$cookie;
    }

    protected function checkTestingPage(string|bool $url): bool
    {
        return $url === Constants::TESTING_PAGE_URL;
    }

    protected function addStatisticFields(array $params)
    {
        if (empty($params)) {
            return;
        }
        $this->fields = $params;
    }

    /**
     * @throws SystemException
     */
    protected function getVisitorData(): array
    {
        $guest = CGuest::GetByID($this->visitorId);
        $arGuest = $guest->ExtractFields("f_");
        if (empty($arGuest)) {
            throw new SystemException("Модуль статистики не установлен");
        }
        return $arGuest;
    }

    protected function setParamByCode($code, $array, $writePropCode): void
    {
        !empty($array[$code]) && $this->visitorData[$writePropCode] = $array[$code];
    }

    /**
     * Собираем статистику из модуля Веб-аналитика
     * @param $visitorData
     * @return void
     */
    protected function setVisitorsParams($visitorData): void
    {
        $this->setParamByCode('ID', $visitorData, 'id');
        $this->setParamByCode('TIMESTAMP_X', $visitorData, 'visit_page_time');
        $this->setParamByCode('FAVORITES', $visitorData, 'is_favorites');
        $this->setParamByCode('C_EVENTS', $visitorData, 'events_count');
        $this->setParamByCode('SESSIONS', $visitorData, 'sessions');
        $this->setParamByCode('HITS', $visitorData, 'hits_count');
        $this->setParamByCode('FIRST_SESSION_ID', $visitorData, 'first_session_id');
        $this->setParamByCode('FIRST_DATE', $visitorData, 'first_visit_date');
        $this->setParamByCode('FIRST_URL_FROM', $visitorData, 'first_url_from');
        $this->setParamByCode('FIRST_URL_TO', $visitorData, 'first_url_to');
        $this->setParamByCode('FIRST_URL_TO_404', $visitorData, 'first_url_to_404');
        $this->setParamByCode('FIRST_SITE_ID', $visitorData, 'first_site_id');
        $this->setParamByCode('LAST_SESSION_ID', $visitorData, 'session_id');
        $this->setParamByCode('LAST_DATE', $visitorData, 'visit_date');
        $this->setParamByCode('LAST_USER_ID', $visitorData, 'user_id');
        $this->setParamByCode('LAST_USER_AUTH', $visitorData, 'is_user_auth');
        $this->setParamByCode('LAST_URL_LAST', $visitorData, 'url_last');
        $this->setParamByCode('LAST_URL_LAST_404', $visitorData, 'url_to_404');
        $this->setParamByCode('LAST_USER_AGENT', $visitorData, 'user_agent');
        $this->setParamByCode('LAST_IP', $visitorData, 'ip');
        $this->setParamByCode('LAST_COOKIE', $visitorData, 'cookie');
        $this->setParamByCode('LAST_LANGUAGE', $visitorData, 'language');
        $this->setParamByCode('LAST_SITE_ID', $visitorData, 'site_id');
        $this->setParamByCode('REGION_NAME', $visitorData, 'region_name');
        $this->setParamByCode('CITY_NAME', $visitorData, 'city_name');
        $this->setParamByCode('LAST_CITY_INFO', $visitorData, 'city_info');

        (!empty($this->visitorData['language'])) && $this->visitorData['language'] = Data::getArrayFromMultipleMeta($this->visitorData['language']);
        (!empty($this->visitorData['city_info'])) && $this->visitorData['city_info'] = Data::unserialise($this->visitorData['city_info']);
    }

    protected function getCurTime(): string
    {
        $objDateTime = new DateTime();
        return $objDateTime->format("d-m-Y-H-i-s");
    }

    /**
     * @throws ArgumentException
     */
    protected function addVisitorPageData(): void
    {
        $filePath = $_SERVER["DOCUMENT_ROOT"] . Constants::CONVERSING_LOGS_PATH ."{$this->visitorId}-visitor.json";
        if (!file_exists($filePath)) {
            $fieldsJsonData = Json::encode([1 => $this->fields]);
            file_put_contents($filePath, $fieldsJsonData);
            return;
        }
        $oldFileData = file_get_contents($filePath);
        $curFileData = Json::decode($oldFileData);
        $lastKey = array_key_last($curFileData);
        $lastKey++;
        $curFileData[$lastKey] = $this->fields;
        $fieldsJsonData = Json::encode($curFileData);
        file_put_contents($filePath, $fieldsJsonData);
    }

    protected function saveVisitorPortrait(): void
    {
        $visitorPageParamsPath = $_SERVER["DOCUMENT_ROOT"] . Constants::CONVERSING_LOGS_PATH ."{$this->visitorId}-visitor.json";
        $visitorHistory = [];
        if (file_exists($visitorPageParamsPath)) {
            $fieldsJsonData = file_get_contents($visitorPageParamsPath);
            $visitorHistory =  Json::decode($fieldsJsonData);
        }
        $arVisitorPortrait = $this->visitorData;
        $arVisitorPortrait["history"] = $visitorHistory;
        $arJsData = Json::encode($arVisitorPortrait);
        if (!file_exists($_SERVER["DOCUMENT_ROOT"] . Constants::CONVERSING_OUTPUT_PATH . "{$this->visitorId}-visitor/")) {
            mkdir($_SERVER["DOCUMENT_ROOT"] . Constants::CONVERSING_OUTPUT_PATH . "{$this->visitorId}-visitor/", 0777, true);
        }
        $filePath = $_SERVER["DOCUMENT_ROOT"] . Constants::CONVERSING_OUTPUT_PATH ."{$this->visitorId}-visitor/{$this->visitorId}-{$this->getCurTime()}-portrait.json";
        file_put_contents($filePath, $arJsData);
        if (file_exists($visitorPageParamsPath)) {
            unlink($visitorPageParamsPath);
        }
    }

    /**
     * @throws SystemException
     */
    public function addVisitorAction(string $actionCode): void
    {
        if (empty($actionCode)) {
            return;
        }
        $filePath = $_SERVER["DOCUMENT_ROOT"] . Constants::CONVERSING_LOGS_PATH ."{$this->visitorId}-visitor.json";
        if (!file_exists($filePath)) {
            return;
        }
        $fileData = file_get_contents($filePath);
        $curFileData = Json::decode($fileData);
        $lastKey = array_key_last($curFileData);
        $curFileData[$lastKey]["actions"][] = $actionCode;
        $fieldsJsonData = Json::encode($curFileData);
        file_put_contents($filePath, $fieldsJsonData);
    }

    public function getStatePortrait(): bool {
        return $this->portraitIsComplete;
    }
}
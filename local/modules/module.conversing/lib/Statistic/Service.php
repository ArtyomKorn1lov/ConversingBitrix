<?php

namespace Conversing\Statistic;

use Bitrix\Main\Context;
use Bitrix\Main\SystemException;
use CGuest;
use Bitrix\Main\Type\DateTime;

use Conversing\Constants;

class Service
{
    public static array $params = [];
    private array $fields = [];
    private int $visitorId;

    public function __construct(array $params = null, string|bool $curPage = false)
    {
        try {
            $this->setVisitorUnicId();
            if ($this->checkTestingPage($curPage)) {
                $visitorData = $this->getVisitorData();
                $objDateTime = new DateTime();
                $curDate = $objDateTime->format("d-m-Y-H-i-s");
                file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/conversing-outputs/{$this->visitorId}-{$curDate}-output.txt", var_export($visitorData, true));
                return;
            }
            $this->addStatisticFields($params);
            file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/conversing-logs/{$this->visitorId}.txt", var_export($this->fields, true), FILE_APPEND);
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

    protected function getVisitorData(): array
    {
        $guest = CGuest::GetByID($this->visitorId);
        $arGuest = $guest->ExtractFields("f_");
        if (empty($arGuest)) {
            return [];
        }
        return $arGuest;
    }
}
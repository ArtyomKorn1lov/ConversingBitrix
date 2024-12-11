<?php

namespace Conversing\Controllers\Visit;

use Bitrix\Main\Engine\Controller;
use Conversing\Constants;
use Conversing\Statistic\Service;
use Bitrix\Main\Error;

class VisitController extends Controller
{
    public function configureActions()
    {
        return [
            "visitPage" => [
                "prefilters" => []
            ],
            "emitVisitor" => [
                "prefilters" => []
            ]
        ];
    }

    public function visitPageAction(array $params):? string
    {
        if (empty($params["params"]) || empty($params["curPage"])) {
            $this->addError(new Error('Неверные входные параметры'));
            return null;
        };
        $obService = new Service($params["params"], $params["curPage"]);
        $flag = $obService->getStatePortrait();
        if ($flag) {
            return "Поведенческий портрет пользователя сформирован";
        }
        return "Информация о странице добавлена";
    }

    public function emitVisitorAction(string $code):? string
    {
        if (empty($code)) {
            $this->addError(new Error('Неверные входные параметры'));
            return null;
        };
        $obService = new Service(null, false, true);
        $obService->addVisitorAction($code);
        return "Действие пользователя добавлено в историю";
    }
}
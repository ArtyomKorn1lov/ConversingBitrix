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
            ]
        ];
    }

    public function visitPageAction(array $params):? string
    {
        if (empty($params["params"]) || empty($params["curPage"])) {
            $this->addError(new Error('Неверные входные параметры'));
            return null;
        };
        new Service($params["params"], $params["curPage"]);
        return "SUCCESS";
    }
}
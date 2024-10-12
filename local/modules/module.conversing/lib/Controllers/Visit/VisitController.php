<?php

namespace Conversing\Controllers\Visit;

use Bitrix\Main\Engine\Controller;

class VisitController extends Controller
{
    public function getMessageAction(string $data = ""):? string
    {
        return "Тестовый вывод";
    }
}
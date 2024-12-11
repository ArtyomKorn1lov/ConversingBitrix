<?php

namespace Conversing;

class Constants
{
    public const TESTING_PAGE_URL = '/catalog/pants/';

    public const CONVERSING_LOGS_PATH = "/conversing-logs/";

    public const CONVERSING_OUTPUT_PATH = "/conversing-outputs/";

    public const META_TAGS_CODES = [
        "description" => 'multiple',
        "keywords" => 'multiple',
        "robots" => 'single',
        "second-name" => 'single',
        "type" => 'single'
    ];
}

/*
 * Дата атрибуты для фиксации действий пользователя
data-conversing="add-basket"
data-conversing="make-order"
data-conversing="social-link"
data-conversing="mail-send"
data-conversing="send-question"
*/
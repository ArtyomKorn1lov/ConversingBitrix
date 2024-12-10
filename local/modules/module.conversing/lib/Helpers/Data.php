<?php

namespace Conversing\Helpers;

use CMain;

use Conversing\Constants;

class Data
{
    public static function getArrayFromMultipleMeta(string $multipleString, string $separator = ','): array
    {
        if (empty($multipleString)) {
            return [];
        }
        return explode($separator, $multipleString);
    }

    public static function unserialise(string $serializeData): array
    {
        if (empty($serializeData)) {
            return [];
        }
        return unserialize($serializeData);
    }

    public static function getPagesMetaData(CMain $application): array
    {
        $arMeta = [
            "title" => $application->GetTitle(),
            "curPageURL" => $application->GetCurUri(),
            'curPage' => $application->GetCurPage(false),
        ];
        foreach (Constants::META_TAGS_CODES as $code => $type) {
            $meta = $application->GetPageProperty($code);
            if (empty($meta)) {
                continue;
            }
            $type === 'multiple' && $meta = static::getArrayFromMultipleMeta($meta);
            $arMeta[$code] = $meta;
        }
        return $arMeta;
    }
}
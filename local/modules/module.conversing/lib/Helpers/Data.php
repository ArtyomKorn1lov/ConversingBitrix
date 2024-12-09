<?php

namespace Conversing\Helpers;

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
}
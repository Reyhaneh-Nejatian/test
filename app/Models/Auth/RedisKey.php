<?php

namespace App\Models\Auth;

class RedisKey
{
    // sanctum redis keys
    public const KEYS_FORMAT_SANCTUM_LAST_USAGE_UPDATE = 'sanctum:$id:lstUsgUpd';

    public const KEYS_FORMAT_SANCTUM_TOKEN = 'sanctum:$md5Token:token';

    public const KEYS_FORMAT_SANCTUM_TOKENABLE_ARRT = 'sanctum:$id:tokenable';

    /**
     * generate key
     */
    public static function generateKeyFormat(string $format, ?array $params): string
    {
        if (strpos($format, '$') === false || ! is_array($params)) {
            return $format;
        }

        foreach ($params as $param => $valueParam) {
            if (strpos($format, '$' . $param) !== false) {
                $format = str_replace('$' . $param, $valueParam, $format);
            }
        }

        if (strpos($format, '$') !== false) {
            $format = str_replace('$', '', $format);
        }

        return $format;
    }
}

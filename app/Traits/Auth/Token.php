<?php

namespace App\Traits\Auth;



/**
 * Token
 */
trait Token
{
    /**
     * return token name
     */
    private static function tokenName(): string
    {
        //        return 'user:'.md5(Helper::userAgent());
        return 'user:' . md5('123');
    }

    /**
     * Token redis hash key
     */
    private static function tokenRedisHashKey(string $token): string
    {
        if (strpos($token, '|') === false) {
            return md5($token);
        }

        [$id, $token] = explode('|', $token, 2);

        return md5($id);
    }
}

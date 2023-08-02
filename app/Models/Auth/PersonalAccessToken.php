<?php

namespace App\Models\Auth;

use Exception;
use App\Traits\Auth\Token;
use App\Traits\Concerns\UsesUuid;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Jobs\UpdatePersonalAccessToken;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    use UsesUuid, Token;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'token',
        'abilities',
    ];


    // Updates should be locked in every time (Lazy updating)
    public static function boot()
    {
        parent::boot();
        // When updating, cancel normal update and manually update
        // the table asynchronously every hour.
        static::updating(function (self $personalAccessToken) {
            try {
                Cache::remember(RedisKey::generateKeyFormat(RedisKey::KEYS_FORMAT_SANCTUM_LAST_USAGE_UPDATE, ['id' => $personalAccessToken->id]), 600, function () use ($personalAccessToken) {
                    dispatch(new UpdatePersonalAccessToken($personalAccessToken, $personalAccessToken->getDirty()));

                    return now();
                });
            } catch (Exception $e) {
                Log::critical($e->getMessage());
            }

            return false;
        });
    }

    // find token with cache
    public static function findToken($token)
    {

        return parent::findToken($token)??null;
//        $token = Cache::remember(RedisKey::generateKeyFormat(RedisKey::KEYS_FORMAT_SANCTUM_TOKEN, ['md5Token' => static::tokenRedisHashKey($token)]), 600, function () use ($token) {
//            return parent::findToken($token) ?? '_null_';
//        });

        if ($token === '_null_' || static::tokenName() !== $token->name) {
            return null;
        }

        return $token;
    }

    // tokenable with cache
    public function getTokenableAttribute()
    {
        return Cache::remember(RedisKey::generateKeyFormat(RedisKey::KEYS_FORMAT_SANCTUM_TOKENABLE_ARRT, ['id' => $this->id]), 600, function () {
            return parent::tokenable()->first();
        });
    }
}

<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use App\Models\Auth\PersonalAccessToken as PersonalAccessToken;

use Laravel\Sanctum\Sanctum;


class CustomSanctumServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
//        $this->app->bind(SanctumPersonalAccessToken::class, CustomPersonalAccessToken::class);

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
//        Sanctum::personalAccessTokenModel(PersonalAccessToken::class);
    }
}

<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Validator::extend('exists_not_soft_deleted', function ($attribute, $value, $parameters, $validator) {
            return User::where('email', $value)->whereNull('deleted_at')->exists();
        });
    }
}

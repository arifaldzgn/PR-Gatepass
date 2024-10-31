<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class CustomValidationRulesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        Validator::extend('nullable_default_string', function ($attribute, $value, $parameters, $validator) {
            if ($value === null || trim($value) === '') {
                $validator->addImplicit('remark', '-');
                return true;
            }

            return is_string($value);
        });
    }
}

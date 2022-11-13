<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Validator::extend('image64', function($attribute, $value, $paramenters, $validator){
            $ext = explode( '/' , explode( ':' , substr($value,0, strpos($value, ";")))[1])[1];
            if(in_array($ext, $paramenters)){
                return true;
            }else{
                return false;
            }
        });

        Validator::replacer('image64', function($message, $attribute, $rule, $paramenters){
            return str_replace(':values' , join("," , $paramenters), $message);
        });
    }
}

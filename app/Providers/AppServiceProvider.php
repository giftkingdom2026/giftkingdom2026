<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use DB;

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

        if(file_exists(storage_path('installed'))){
            $result = array();
            
            //new customers
            $newCustomers = DB::table('users')
                ->where('verified','=', 0)
                ->orderBy('id','desc')
                ->get();

            //products low in quantity
            

            $languages = DB::table('languages')->get();
            view()->share('languages', $languages);
            $images = '';
            $web_setting = DB::table('settings')->get();
            view()->share('web_setting', $web_setting);
            view()->share('images', $images);
            
            
        }
    }
}

<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use HTML, Request, URL;

class MaxfineHtmlServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{

        /**
         * ---------------------------------------------------------
         * 高亮当前菜单
         * http://laravel.so/tricks/bcf5247b77fb838ce10115c6adf2fc68
         * ---------------------------------------------------------
         * HTML::macro不能放在AppServiceProvider::boot中, 应为在此处运行时, HTML还没有建立.
         */
        HTML::macro('menu_active', function($route,$name)
        {
            if (Request::is($route . '/*') || Request::is($route)) {
                $active ='<li class="active"><a href="'.URL::to($route).'">'.$name.'</a></li>';
            } else {
                $active ='<li><a href="'.URL::to($route).'">'.$name.'</a></li>';
            }

            return $active;
        });

        /**
        HTML::macro('menu_active', function($route,$name)
        {
            if (Request::is($route . '/*') || Request::is($route)) {
                $active ='<li class="active"><a href="'.URL::to($route).'"><i class="fa fa-circle-o"></i>'.$name.'</a></li>';
            } else {
                $active ='<li><a href="'.URL::to($route).'"><i class="fa fa-circle-o"></i>'.$name.'</a></li>';
            }

            return $active;
        });
        **/
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
	}

}

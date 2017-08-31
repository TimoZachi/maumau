<?php
namespace MauMau\Providers;

use Blade;
use Config;
use DB;
use Illuminate\Support\ServiceProvider;

class MauMauServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
	    if(Config::get('app.debug'))
	    {
		    DB::connection()->enableQueryLog();
	    }

	    Blade::directive('controller', function ($expression)
	    {
		    $segments = explode(',', preg_replace("/[()\"']/", '', $expression));

		    if(strpos($segments[0], '@') !== false) {
			    list($controller, $method) = explode('@', trim($segments[0]));
		    } else {
			    $controller = trim($segments[0]); $method = trim($segments[1]);
		    }

		    $controller = '\\MauMau\\Http\\Controllers\\' . $controller;

		    return "<?php echo App::make('{$controller}')->$method()->render(); ?>";
	    });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

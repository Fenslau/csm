<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;

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
        if($this->app->environment('staging') OR $this->app->environment('production')) {
    			\URL::forceScheme('https');
    		}
        Paginator::useBootstrap();
        setlocale(LC_ALL, 'ru_RU.UTF-8');
        DB::statement("SET lc_time_names = 'ru_RU'");
        Carbon::setLocale(config('app.locale'));
        Blade::directive('selected', function ($parameters) {
            [$value, $expected] = explode(',', $parameters);
            $value = trim($value, '\'');
              return "value=\"$value\" <?php if (is_array($expected)) {
                if (in_array('$value', $expected)) echo 'selected';
              } else { if ('$value' === $expected) echo 'selected'; } ?>";

        });
        Blade::directive('dec', function ($expression) {
          return "<?php echo number_format((float)$expression, 0, ',', ' '); ?>";
        });        
      }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;

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
        Paginator::useBootstrap();

        Blade::directive('selected', function ($parameters) {
            [$value, $expected] = explode(',', $parameters);
            $value = trim($value, '\'');
              return "value=\"$value\" <?php if (is_array($expected)) {
                if (in_array('$value', $expected)) echo 'selected';
              } else { if ('$value' === $expected) echo 'selected'; } ?>";

        });
      }
}

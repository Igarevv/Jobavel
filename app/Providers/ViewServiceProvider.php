<?php

namespace App\Providers;

use App\View\Components\CategoriesView;
use App\View\Components\LogoView;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
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
    public function boot(): void
    {
        Blade::component('image.logo', LogoView::class);
        Blade::component('categories.list', CategoriesView::class);

        View::share('currentYear', date('Y'));

        View::composer('*', function ($view) {
            $view->with('user.role', Session::get('user.role'));
        });
        Blade::directive('greeting', function () {
            return '<?php
                $currentHour = now()->hour;
                $currentDay = now()->dayName;

                if ($currentHour >= 5 && $currentHour < 12) {
                    $period = "morning";
                } elseif ($currentHour >= 12 && $currentHour < 17) {
                    $period = "afternoon";
                } elseif ($currentHour >= 17 && $currentHour < 20) {
                    $period = "evening";
                } else {
                    $period = "night";
                }
                echo "Happy <mark class=\"marker\">{$currentDay}</mark> $period";
            ?>';
        });
    }

}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Repository\TaskRepository'
        );
        $this->app->bind(
            'App\Repository\MonthlyTaskRepository'
        );
        $this->app->bind(
            'App\Repository\WeeklyTaskRepository'
        );
        $this->app->bind(
            'App\Repository\DailyTaskRepository'
        );
        $this->app->bind(
            'Domain\Service\ValuationService'
        );
    }
}

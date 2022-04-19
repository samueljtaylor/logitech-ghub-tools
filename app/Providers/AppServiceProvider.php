<?php

namespace App\Providers;

use App\Contracts\AppDatabaseContract;
use App\Repositories\AppDatabase;
use App\Services\PlatformResolver;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Collection::macro('recursive', function () {
            return $this->map(function ($val) {
                if (is_array($val)) {
                    return (new Collection($val))->recursive();
                }

                return $val;
            });
        });

        $this->app->bind(AppDatabaseContract::class, function () {
            return new AppDatabase(PlatformResolver::resolvePathBuilder());
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

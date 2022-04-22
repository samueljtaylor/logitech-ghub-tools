<?php

namespace App\Providers;

use App\Connectors\AppDatabase;
use App\Contracts\Repositories\FileRepository as FileRepositoryContract;
use App\Repositories\FileRepository;
use App\Services\PlatformResolver;
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
        $this->app->bind(AppDatabase::class, function () {
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

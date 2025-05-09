<?php

namespace App\Providers;

use App\Repositories\Interfaces\ContatoRepositoryInterface;
use App\Repositories\Eloquent\ContatoRepository;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ContatoRepositoryInterface::class, ContatoRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

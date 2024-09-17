<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\PetRepositoryInterface;
use App\Repositories\PetRepository;

class PetServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PetRepositoryInterface::class,PetRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

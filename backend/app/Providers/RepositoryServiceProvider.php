<?php

namespace App\Providers;

use App\Repositories\Interfaces\OrderDetailRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\PizzaRepositoryInterface;
use App\Repositories\Interfaces\PizzaTypeRepositoryInterface;
use App\Repositories\OrderDetailRepository;
use App\Repositories\OrderRepository;
use App\Repositories\PizzaRepository;
use App\Repositories\PizzaTypeRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PizzaTypeRepositoryInterface::class, PizzaTypeRepository::class);
        $this->app->bind(PizzaRepositoryInterface::class, PizzaRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(OrderDetailRepositoryInterface::class, OrderDetailRepository::class);
    }
    
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

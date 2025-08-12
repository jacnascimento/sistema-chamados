<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\CrudRepositoryInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\TicketRepository;
use App\Services\Interfaces\CrudServiceInterface;
use App\Services\CategoryService;
use App\Services\TicketService;
use App\Models\Category;
use App\Models\Ticket;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CrudRepositoryInterface::class, function ($app) {
            return new CategoryRepository(new Category());
        });
        
        $this->app->bind(CategoryRepository::class, function ($app) {
            return new CategoryRepository(new Category());
        });

        $this->app->bind(CategoryService::class, function ($app) {
            return new CategoryService($app->make(CategoryRepository::class));
        });
        
        $this->app->bind(TicketRepository::class, function ($app) {
            return new TicketRepository(new Ticket());
        });

        $this->app->bind(TicketService::class, function ($app) {
            return new TicketService($app->make(TicketRepository::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

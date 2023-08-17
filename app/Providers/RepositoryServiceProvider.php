<?php

namespace App\Providers;

use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Repositories\TaskRepository;
use App\Services\TaskService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);

        $this->app->singleton(TaskRepository::class, function (Application $app) {
            return new TaskRepository();
        });

        $this->app->singleton(TaskService::class, function (Application $app) {
            return new TaskService($app->make(TaskRepository::class));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

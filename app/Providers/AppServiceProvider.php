<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\CartService;
use App\Services\ProductService;
use App\Services\TransactionService;
use App\Services\AdminTransactionService;
use App\Services\UserService;
use App\Services\AddressService;
use App\Services\PaymentService;
use App\Services\ArticleService;
use App\Services\ComplaintService;
use App\Services\OllamaService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register Services with proper dependency injection
        $this->app->singleton(ProductService::class, function ($app) {
            return new ProductService();
        });

        $this->app->singleton(CartService::class, function ($app) {
            return new CartService($app->make(ProductService::class));
        });

        $this->app->singleton(TransactionService::class, function ($app) {
            return new TransactionService($app->make(CartService::class));
        });

        $this->app->singleton(AdminTransactionService::class, function ($app) {
            return new AdminTransactionService();
        });

        $this->app->singleton(UserService::class, function ($app) {
            return new UserService();
        });

        $this->app->singleton(AddressService::class, function ($app) {
            return new AddressService();
        });

        $this->app->singleton(PaymentService::class, function ($app) {
            return new PaymentService();
        });

        $this->app->singleton(ArticleService::class, function ($app) {
            return new ArticleService();
        });

        $this->app->singleton(ComplaintService::class, function ($app) {
            return new ComplaintService();
        });

        $this->app->singleton(OllamaService::class, function ($app) {
            return new OllamaService();
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

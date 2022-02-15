<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * @desc Genera el enlace entre la clase repository y su interface, para ser utilizada mediante esta
     * @author Juan Pablo Camargo Vanegas
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repositories\interfaces\IUserRepository', 'App\Repositories\UserRepository');
        $this->app->bind('App\Repositories\interfaces\IOrderRepository', 'App\Repositories\OrdersRepository');
        $this->app->bind('App\Repositories\interfaces\IWebCheckoutRepository', 'App\Repositories\WebCheckoutRepository');
        $this->app->bind('App\Repositories\interfaces\IProductRepository', 'App\Repositories\ProductsRepository');
    }
}

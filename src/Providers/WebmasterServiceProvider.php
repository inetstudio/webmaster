<?php

namespace InetStudio\Webmaster\Providers;

use Illuminate\Support\ServiceProvider;
use InetStudio\Webmaster\Services\WebmasterService;
use InetStudio\Webmaster\Contracts\Services\WebmasterServiceContract;

/**
 * Class WebmasterServiceProvider
 * @package InetStudio\Webmaster\Providers
 */
class WebmasterServiceProvider extends ServiceProvider
{
    /**
     * Загрузка сервиса.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPublishes();
        $this->registerRoutes();
        $this->registerViews();
    }

    /**
     * Регистрация привязки в контейнере.
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerBindings();
    }

    /**
     * Регистрация ресурсов.
     *
     * @return void
     */
    protected function registerPublishes(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/services.php', 'services.yandex.webmaster'
        );
    }

    /**
     * Регистрация путей.
     *
     * @return void
     */
    protected function registerRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
    }

    /**
     * Регистрация представлений.
     *
     * @return void
     */
    protected function registerViews(): void
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'admin.module.webmaster');
    }

    /**
     * Регистрация привязок, алиасов и сторонних провайдеров сервисов.
     *
     * @return void
     */
    public function registerBindings(): void
    {
        $this->app->singleton(WebmasterServiceContract::class, WebmasterService::class);
    }
}

<?php

namespace InetStudio\Webmaster\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class WebmasterBindingsServiceProvider.
 */
class WebmasterBindingsServiceProvider extends ServiceProvider
{
    /**
    * @var  bool
    */
    protected $defer = true;

    /**
    * @var  array
    */
    public $bindings = [
        'InetStudio\Webmaster\Contracts\Services\WebmasterServiceContract' => 'InetStudio\Webmaster\Services\WebmasterService',
    ];

    /**
     * Получить сервисы от провайдера.
     *
     * @return  array
     */
    public function provides()
    {
        return array_keys($this->bindings);
    }
}

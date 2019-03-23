<?php

namespace InetStudio\Webmaster\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

/**
 * Class WebmasterBindingsServiceProvider.
 */
class WebmasterBindingsServiceProvider extends ServiceProvider implements DeferrableProvider
{
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

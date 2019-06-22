<?php

namespace InetStudio\WebmasterPackage\Webmaster\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

/**
 * Class BindingsServiceProvider.
 */
class BindingsServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * @var  array
     */
    public $bindings = [
        'InetStudio\WebmasterPackage\Webmaster\Contracts\Http\Controllers\Back\WebmasterControllerContract' => 'InetStudio\WebmasterPackage\Webmaster\Http\Controllers\Back\WebmasterController',
        'InetStudio\WebmasterPackage\Webmaster\Contracts\Http\Responses\Back\ConfigResponseContract' => 'InetStudio\WebmasterPackage\Webmaster\Http\Responses\Back\ConfigResponse',
        'InetStudio\WebmasterPackage\Webmaster\Contracts\Http\Responses\Back\CallbackResponseContract' => 'InetStudio\WebmasterPackage\Webmaster\Http\Responses\Back\CallbackResponse',
        'InetStudio\WebmasterPackage\Webmaster\Contracts\Services\Back\WebmasterServiceContract' => 'InetStudio\WebmasterPackage\Webmaster\Services\Back\WebmasterService',
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

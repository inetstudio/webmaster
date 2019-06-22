<?php

namespace InetStudio\WebmasterPackage\Webmaster\Http\Controllers\Back;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\WebmasterPackage\Webmaster\Contracts\Services\Back\WebmasterServiceContract;
use InetStudio\WebmasterPackage\Webmaster\Contracts\Http\Responses\Back\ConfigResponseContract;
use InetStudio\WebmasterPackage\Webmaster\Contracts\Http\Responses\Back\CallbackResponseContract;
use InetStudio\WebmasterPackage\Webmaster\Contracts\Http\Controllers\Back\WebmasterControllerContract;

/**
 * Class WebmasterController.
 */
class WebmasterController extends Controller implements WebmasterControllerContract
{
    /**
     * Отображаем конфиг.
     *
     * @param  WebmasterServiceContract  $webmasterService
     *
     * @return ConfigResponseContract
     *
     * @throws BindingResolutionException
     */
    public function config(WebmasterServiceContract $webmasterService): ConfigResponseContract
    {
        $config = $webmasterService->getConfig();

        return $this->app->make(ConfigResponseContract::class, compact('config'));
    }

    /**
     * Обработка ответа при авторизации в webmaster'е.
     *
     * @param  WebmasterServiceContract  $webmasterService
     * @param  Request  $request
     *
     * @return CallbackResponseContract
     *
     * @throws BindingResolutionException
     */
    public function callback(WebmasterServiceContract $webmasterService, Request $request): CallbackResponseContract
    {
        $token = $webmasterService->getToken($request);

        return $this->app->make(CallbackResponseContract::class, compact('token'));
    }
}

<?php

namespace InetStudio\WebmasterPackage\Webmaster\Contracts\Http\Controllers\Back;

use Illuminate\Http\Request;
use InetStudio\WebmasterPackage\Webmaster\Contracts\Services\Back\WebmasterServiceContract;
use InetStudio\WebmasterPackage\Webmaster\Contracts\Http\Responses\Back\ConfigResponseContract;
use InetStudio\WebmasterPackage\Webmaster\Contracts\Http\Responses\Back\CallbackResponseContract;

/**
 * Interface WebmasterControllerContract.
 */
interface WebmasterControllerContract
{
    /**
     * Отображаем конфиг.
     *
     * @param  WebmasterServiceContract  $webmasterService
     *
     * @return ConfigResponseContract
     */
    public function config(WebmasterServiceContract $webmasterService): ConfigResponseContract;

    /**
     * Обработка ответа при авторизации в webmaster'е.
     *
     * @param  WebmasterServiceContract  $webmasterService
     * @param  Request  $request
     *
     * @return CallbackResponseContract
     */
    public function callback(WebmasterServiceContract $webmasterService, Request $request): CallbackResponseContract;
}

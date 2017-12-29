<?php

namespace InetStudio\Webmaster\Contracts\Services;

use Illuminate\Http\Request;

/**
 * Interface WebmasterServiceContract
 * @package InetStudio\Webmaster\Contracts\Services
 */
interface WebmasterServiceContract
{
    /**
     * Получаем конфигурацию Webmaster'a.
     *
     * @return array
     */
    public function getConfig(): array;

    /**
     * @param Request $request
     * @return array
     */
    public function getToken(Request $request): array;

    /**
     * @param $object
     */
    public function sendToWebmaster($object): void;
}

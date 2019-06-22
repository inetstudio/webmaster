<?php

namespace InetStudio\WebmasterPackage\Webmaster\Http\Responses\Back;

use Illuminate\Http\Request;
use InetStudio\WebmasterPackage\Webmaster\Contracts\Http\Responses\Back\ConfigResponseContract;

/**
 * Class ConfigResponse.
 */
class ConfigResponse implements ConfigResponseContract
{
    /**
     * @var array
     */
    protected $data;

    /**
     * ConfigResponse constructor.
     *
     * @param  array  $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Возвращаем ответ при просмотре конфига.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function toResponse($request)
    {
        return view('admin.module.webmaster::back.pages.index', $this->data);
    }
}

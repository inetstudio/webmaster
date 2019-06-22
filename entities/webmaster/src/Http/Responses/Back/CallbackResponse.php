<?php

namespace InetStudio\WebmasterPackage\Webmaster\Http\Responses\Back;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use InetStudio\WebmasterPackage\Webmaster\Contracts\Http\Responses\Back\CallbackResponseContract;

/**
 * Class CallbackResponse.
 */
class CallbackResponse implements CallbackResponseContract
{
    /**
     * @var array
     */
    protected $token;

    /**
     * ConfigResponse constructor.
     *
     * @param  array  $token
     */
    public function __construct(array $token)
    {
        $this->token = $token;
    }

    /**
     * Возвращаем ответ при сохранении объекта.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        Session::flash('webmaster_access', $this->token);

        return response()->redirectToRoute('back.webmaster.config');
    }
}

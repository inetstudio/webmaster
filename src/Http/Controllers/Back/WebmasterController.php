<?php

namespace InetStudio\Webmaster\Http\Controllers\Back;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use InetStudio\Webmaster\Contracts\Services\WebmasterServiceContract;

/**
 * Class WebmasterController
 * @package InetStudio\Webmaster\Http\Controllers\Back
 */
class WebmasterController extends Controller
{
    /**
     * Используемые сервисы.
     *
     * @var array
     */
    private $services = [];

    /**
     * WebmasterController constructor.
     */
    public function __construct()
    {
        $this->services['webmasterService'] = app()->make(WebmasterServiceContract::class);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex(): View
    {
        return view('admin.module.webmaster::back.pages.index', [
            'config' => $this->services['webmasterService']->getConfig(),
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function callback(Request $request): RedirectResponse
    {
        Session::flash('webmaster_access', $this->services['webmasterService']->getToken($request));

        return response()->redirectToRoute('back.webmaster.index');
    }
}

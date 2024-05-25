<?php

namespace SAAS\Http\Languages\Controller;

use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;
use SAAS\Lang\Lang;

class LanguageStoreController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->session()->put('language', Lang::tryFrom($request->input('language'))?->value ?? config('app.locale'));

        return back();
    }
}

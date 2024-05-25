<?php

namespace SAAS\Http\Docs\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use SAAS\App\Controllers\Controller;

class DocsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $file = 'index')
    {
        if ($file != 'index') {
            $file = $file . '/index';
        }
        return File::get(public_path() . '/docs/' . $file . '.html');
    }
}

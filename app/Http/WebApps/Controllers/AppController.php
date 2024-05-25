<?php

namespace SAAS\Http\WebApps\Controllers;

use SAAS\App\Controllers\Controller;
use SAAS\Domain\WebApps\Models\App;

class AppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apps = App::defaultOrder()->active()->get();

        return view('apps.index', compact('apps'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \SAAS\Domain\WebApps\Models\App  $app
     * @return \Illuminate\Http\Response
     */
    public function show(App $app)
    {
        $app->loadMissing([
            'features.feature',
        ]);

        return view('apps.show', compact('app'));
    }
}

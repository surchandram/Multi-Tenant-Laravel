<?php

namespace SAAS\Http\Admin\Controllers\Settings;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Laraeast\LaravelSettings\Facades\Settings;
use SAAS\App\Controllers\Controller;
use SAAS\Http\Settings\Requests\SettingsStoreRequest;

class SettingController extends Controller
{
    /**
     * SettingController constructor.
     */
    public function __construct()
    {
        $this->middleware(['permission:manage settings']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = (Settings::all());

        return Inertia::render('admin/views/settings/Index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SettingsStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SettingsStoreRequest $request)
    {
        $key = $request->key;
        $value = $request->value;

        Settings::set($key, $value);

        if ($request->expectsJson()) {
            return response()->noContent();
        }

        return back()->withSuccess(__(':key :action successfully.', [
            'key' => $key,
            'action' => $request->editing ? 'updated' : 'added',
        ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  mixed  $setting
     * @return \Illuminate\Http\Response
     */
    public function show($setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  mixed  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit($setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $setting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy($setting)
    {
        Settings::delete($setting);

        return redirect()->route('admin.settings.index')->withSuccess(__(':key removed from settings.', ['key' => $setting]));
    }
}

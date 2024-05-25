<?php

namespace SAAS\Http\Admin\Controllers\WebApps;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\WebApps\Models\App;

class AppLogoController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \SAAS\Domain\Apps\Models\App  $app
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, App $app)
    {
        $this->authorize('update', $app);

        $this->validate($request, [
            'logo' => ['required', 'image:png,jpg,jpeg'],
        ]);

        try {
            DB::transaction(function () use (&$app) {
                $app->addMediaFromRequest('logo')
                    ->withResponsiveImages()
                    ->toMediaCollection('logo');
            });
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'errors' => [
                        'logo' => [$e->getMessage()],
                    ],
                    'trace' => $e->getTrace(),
                ], 422);
            }

            return back()->withInput()->withErrors([
                'logo' => [$e->getMessage()],
            ]);
        }

        if ($request->expectsJson()) {
            return response()->noContent();
        }

        return back()->withSuccess(__('Logo updated successfully.'));
    }
}

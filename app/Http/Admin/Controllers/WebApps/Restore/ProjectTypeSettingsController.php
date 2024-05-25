<?php

namespace SAAS\Http\Admin\Controllers\WebApps\Restore;

use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\WebApps\Enums\Apps\Restore;
use SAAS\Domain\WebApps\ViewModels\Admin\GetProjectTypeSettingsViewModel;

class ProjectTypeSettingsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response|\Momentum\Modal\Modal
     */
    public function index(Request $request)
    {
        $model = new GetProjectTypeSettingsViewModel($request);

        return inertia()
            ->modal('admin/modals/WebApps/Restore/ProjectTypeSettingsModal', compact('model'))
            ->baseRoute('admin.dashboard');
    }

    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        setting()->set(Restore::PROJECT_TYPES_COLORS->value, $request->all());
        setting()->save();

        return back()->withSuccess(__('admin.apps.restore.settings.updated'));
    }
}

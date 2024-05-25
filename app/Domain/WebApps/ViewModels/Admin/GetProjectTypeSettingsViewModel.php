<?php

namespace SAAS\Domain\WebApps\ViewModels\Admin;

use Illuminate\Http\Request;
use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Restore\Enums\ProjectTypes;
use SAAS\Domain\WebApps\Enums\Apps\Restore;

class GetProjectTypeSettingsViewModel extends ViewModel
{
    public function __construct(
        public readonly Request $request,
    ) {
    }

    public function settings()
    {
        return setting(
            'restore_project_types_colors',
            collect(array_keys($this->types()))
                ->mapWithKeys(
                    fn ($key) => [
                        $key => setting(Restore::PROJECT_TYPES_COLORS->value),
                    ]
                )
        );
    }

    public function types()
    {
        return ProjectTypes::asFormObject();
    }
}

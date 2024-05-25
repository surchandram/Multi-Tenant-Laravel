<?php

namespace SAAS\Domain\Users\ViewModels\Admin;

use Illuminate\Http\Request;
use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Users\DataTransferObjects\UserData;
use SAAS\Domain\Users\Filters\UserFilters;
use SAAS\Domain\Users\Models\User;

class UsersIndexViewModel extends ViewModel
{
    public function __construct(
        protected readonly ?Request $request
    ) {
    }

    public function users()
    {
        return UserData::collection(
            User::filter($this->request)
                ->withCount(['companies'])
                ->with(['media'])
                ->paginate()
        );
    }

    public function filters()
    {
        return UserFilters::mappings();
    }
}

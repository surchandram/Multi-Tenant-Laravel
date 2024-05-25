<?php

namespace SAAS\Domain\Users\ViewModels\Admin;

use Miracuthbert\LaravelRoles\Permitable;
use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Users\DataTransferObjects\RoleData;
use SAAS\Domain\Users\DataTransferObjects\UserData;
use SAAS\Domain\Users\Models\Role;
use SAAS\Domain\Users\Models\User;

class UpsertUserViewModel extends ViewModel
{
    public function __construct(
        public readonly ?User $user = null,
    ) {
        if ($this->user) {
            $this->user->loadMissing([
                'roles' => fn ($query) => $query->type(Permitable::ADMIN)->orderByPivot('expires_at', 'asc'),
                'media',
            ]);
        }
    }

    public function roles()
    {
        return RoleData::collection(
            Role::with([
                'parent',
            ])->whereType(Permitable::ADMIN)->has('permissions')->get()
        );
    }

    public function user()
    {
        if (! $this->user) {
            return [];
        }

        return UserData::fromModel($this->user);
    }

    public function meta(): array
    {
        return [
            'per_page' => 5,
        ];
    }
}

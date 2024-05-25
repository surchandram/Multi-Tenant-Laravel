<?php

namespace SAAS\Domain\Tenant\ViewModels;

use Illuminate\Http\Request;
use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Tenant\Actions\VerifyUserIsCustomerAction;

class HomepageViewModel extends ViewModel
{
    public function __construct(
        public readonly ?Request $request
    ) {
    }

    public function images()
    {
        return [
            'restore' => asset('images/customer_portal_project.png'),
        ];
    }

    public function isVerifiedCustomer()
    {
        if (! filled($this->user())) {
            return [];
        }

        return VerifyUserIsCustomerAction::execute($this->request->user(), $this->request->tenant());
    }

    public function can()
    {
        if (! filled($this->user())) {
            return [];
        }

        return [
            'browse_tenant_dashboard' => $this->user()->can('view company dashboard', $this->tenant()),
        ];
    }

    protected function user()
    {
        return $this->request->user();
    }

    protected function tenant()
    {
        return $this->request->tenant();
    }
}

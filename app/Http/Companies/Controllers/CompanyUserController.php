<?php

namespace SAAS\Http\Companies\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Companies\ViewModels\CompanyUsersCreateViewModel;
use SAAS\Domain\Companies\ViewModels\CompanyUsersIndexViewModel;
use SAAS\Domain\Companies\ViewModels\EditCompanyUserViewModel;
use SAAS\Domain\Users\Models\User;
use SAAS\Domain\Users\Models\UserInvitation;
use SAAS\Http\Companies\Requests\CompanyUserStoreRequest;

class CompanyUserController extends Controller
{
    /**
     * CompanyUserController constructor.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware(['auth']);
        $this->middleware(['in_team:'.$request->company]);
        $this->middleware(['permission:add company user,company:'.$request->company])->only('create', 'store');
        $this->middleware(['permission:assign company roles,company:'.$request->company])->only('edit', 'update');
        $this->middleware(['permission:delete company user,company:'.$request->company])->only('destroy');
        $this->middleware(['password.confirm'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Company $company)
    {
        $model = new CompanyUsersIndexViewModel($request, $company);

        return Inertia::render(
            'companies/views/users/Index',
            compact('model')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Company $company)
    {
        if ($company->hasReachedPlanLimit()) {
            return redirect()
                ->back()
                ->withError(__('app.subscription.upgrade_first'));
        }

        $model = new CompanyUsersCreateViewModel($company);

        return Inertia::render(
            'companies/views/users/Create',
            compact('model')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyUserStoreRequest $request, Company $company)
    {
        if ($company->hasReachedPlanLimit()) {
            return back()->withErrors([
                'general' => __('app.subscription.reached_limit'),
            ])
                ->withError(__('app.subscription.upgrade_first'));
        }

        $data = [
            'team_id' => $request->validated('team_id'),
        ];

        $invitation = DB::transaction(function () use ($request, $company, $data) {
            $invitation = new UserInvitation;
            $invitation->fill($request->validated());
            $invitation->referable()->associate($request->user());
            $invitation->roleable()->associate($company);
            $invitation->data = $data;
            $invitation->save();

            return $invitation;
        });

        if ($invitation->id) {
            return redirect()->route('companies.users.index', $company)->withSuccess(__('app.invitation.send_success'));
        }

        return back()->withErrors([
            'general' => __('app.invitation.send_failed'),
        ])->withError(__('app.invitation.send_failed'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company, User $user)
    {
        if (! $company->users->contains($user)) {
            return back();
        }

        $model = new EditCompanyUserViewModel($company, $user);

        return Inertia::render(
            'companies/views/users/Show',
            compact('model')
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company, User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company, User $user)
    {
        if (! $company->users->contains($user)) {
            return redirect()->route('companies.users.index', $company);
        }

        if ($user->isOnlyAdminInCompany($company)) {
            return redirect()->route('companies.users.index', $company);
        }

        if ($company->users->count() === 1) {
            return back();
        }

        $company->users()->detach($user->id);

        $user->detachRoles([], $company);

        $company->flushCache();

        return redirect()->route('companies.users.index', $company)->withSuccess(
            __(':name removed from company.', ['name' => $user->name])
        );
    }
}

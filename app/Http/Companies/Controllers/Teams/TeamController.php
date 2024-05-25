<?php

namespace SAAS\Http\Companies\Controllers\Teams;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Teams\Actions\UpsertTeamAction;
use SAAS\Domain\Teams\DataTransferObjects\TeamData;
use SAAS\Domain\Teams\Events\TeamCreated;
use SAAS\Domain\Teams\Models\Team;
use SAAS\Domain\Teams\ViewModels\EditTeamViewModel;
use SAAS\Domain\Teams\ViewModels\ShowTeamViewModel;
use SAAS\Http\Teams\Requests\TeamStoreRequest;
use SAAS\Http\Teams\Requests\TeamUpdateRequest;

class TeamController extends Controller
{
    /**
     * TeamController constructor.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware(['auth']);
        $this->middleware(['in_team:'.$request->company])->except('index', 'create', 'store');
        $this->middleware(['permission:view company dashboard,company:'.($request->company)])->only('show');
        $this->middleware(['permission:update company,company:'.$request->company])->only('edit', 'update');
        $this->middleware(['permission:delete company,company:'.$request->company])->only('destroy');
        // $this->middleware(['password.confirm'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \SAAS\Domain\Companies\Models\Company
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Company $company)
    {
        $teams = TeamData::collection($company->teams)->toArray();

        return Inertia::render('companies/views/teams/Index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('companies/views/teams/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(TeamStoreRequest $request, Company $company)
    {
        $user = $request->user();

        try {
            $team = UpsertTeamAction::execute(
                TeamData::fromRequest($request),
                $company
            );

            event(new TeamCreated($team));
        } catch (\Exception $e) {
            logger()->debug($e->getMessage(), $e->getTrace());

            return redirect()->back()->withInput()->withErrors([
                'general' => $e->getMessage(),
            ]);
        }

        return redirect()->route('companies.edit', $company)
            ->withSuccess(
                __('Team \':name\' created successfully.', ['name' => $team->name]
                )
            );
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company, Team $team)
    {
        $model = new ShowTeamViewModel($company, $team);

        return Inertia::render('companies/views/teams/Show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company, Team $team)
    {
        $model = new EditTeamViewModel($company, $team);

        return Inertia::render('companies/views/teams/Edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(TeamUpdateRequest $request, Company $company, Team $team)
    {
        try {
            UpsertTeamAction::execute(
                TeamData::fromRequest($request),
                $company
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());

            return redirect()->route('companies.edit', $company)
                ->withSuccess(
                    __(':name failed updating.', [
                        'name' => $team->name,
                    ])
                );
        }

        return redirect()->route('companies.edit', $company)
            ->withSuccess(
                __(':name successfully updated.', [
                    'name' => $team->name,
                ])
            );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company, Team $team)
    {
        try {
            $team->delete();
        } catch (\Exception $e) {
            return redirect()->route('companies.edit', $company)
                ->withError(
                    __('Failed deleting team.')
                );
        }

        return redirect()->route('companies.edit', $company)
            ->withSuccess(
                __(':name successfully deleted from your teams.', [
                    'name' => $team->name,
                ])
            );
    }
}

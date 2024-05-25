<?php

namespace SAAS\Http\Companies\Controllers\Teams;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Http\Companies\Requests\Teams\TeamUserStoreRequest;

class TeamUserStoreController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(TeamUserStoreRequest $request, Company $company)
    {
        try {
            $added = $request->addTeamMember();

            if (! $added) {
                return back()->withErrors([
                    'user_id' => __('app.messages.team_member_store_fail'),
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed adding team member.', [$e]);

            return back()->withErrors([
                'user_id' => __('app.messages.team_member_store_fail'),
            ]);
        }

        return back()->withSuccess(
            __('app.messages.team_member_store_success')
        );
    }
}

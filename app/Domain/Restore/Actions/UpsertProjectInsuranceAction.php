<?php

namespace SAAS\Domain\Restore\Actions;

use Illuminate\Support\Facades\DB;
use SAAS\Domain\Restore\DataTransferObjects\InsuranceData;
use SAAS\Domain\Restore\Models\Project;
use SAAS\Domain\Restore\Models\ProjectInsurance;
use SAAS\Domain\Tenant\Actions\UpsertOrganizationAction;

class UpsertProjectInsuranceAction
{
    public static function execute(InsuranceData $insuranceData, Project $project): ProjectInsurance
    {
        try {
            $insurance = DB::transaction(function () use ($insuranceData, $project) {
                // insurance details
                $data = [
                    'policy_no' => $insuranceData->policy_no,
                    'claim_no' => $insuranceData->claim_no,
                    'deductible' => $insuranceData->deductible,
                ];

                // setup insurance company
                $company = UpsertOrganizationAction::execute(
                    $insuranceData->company
                );

                // agent setup
                if (filled($insuranceData->agent)) {
                    $agent = UpsertInsuranceAgentAction::execute(
                        $insuranceData->agent,
                        $company
                    );

                    $data['agent_id'] = $agent->id;
                }

                // adjuster setup
                if (filled($insuranceData->adjuster)) {
                    $adjuster = UpsertInsuranceAdjusterAction::execute(
                        $insuranceData->adjuster,
                        $company
                    );

                    $data['adjuster_id'] = $adjuster->id;
                }

                // append insurance company field to fillable data
                $data['organization_id'] = $company->id;

                $insurance = ProjectInsurance::firstOrNew([
                    'project_id' => $project->id,
                ]);
                $insurance->fill($data);
                $insurance->save();

                return $insurance;
            });
        } catch (\Exception $e) {
            throw $e;
        }

        return $insurance;
    }
}

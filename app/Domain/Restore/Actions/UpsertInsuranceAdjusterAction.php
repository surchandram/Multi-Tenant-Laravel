<?php

namespace SAAS\Domain\Restore\Actions;

use Illuminate\Support\Facades\DB;
use SAAS\Domain\Tenant\Actions\UpsertPersonAction;
use SAAS\Domain\Tenant\DataTransferObjects\PersonData;
use SAAS\Domain\Tenant\Enums\OrganizationUserRole;
use SAAS\Domain\Tenant\Models\Organization;
use SAAS\Domain\Tenant\Models\Person;

class UpsertInsuranceAdjusterAction
{
    public static function execute(PersonData $personData, Organization $organization): Person
    {
        try {
            $adjuster = DB::transaction(function () use ($personData, $organization) {
                // setup person
                $person = UpsertPersonAction::execute($personData);

                // link user to organization as 'insurance adjuster'
                $model = $organization->users()->firstOrNew([
                    'organization_id' => $organization->id,
                    'person_id' => $person->id,
                    'role' => OrganizationUserRole::InsuranceAdjuster->value,
                ]);

                $model->save();

                return $person;
            });
        } catch (\Exception $e) {
            throw $e;
        }

        return $adjuster;
    }
}

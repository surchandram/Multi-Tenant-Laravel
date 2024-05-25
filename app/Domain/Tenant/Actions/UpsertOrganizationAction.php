<?php

namespace SAAS\Domain\Tenant\Actions;

use Illuminate\Support\Facades\DB;
use SAAS\Domain\Tenant\DataTransferObjects\OrganizationData;
use SAAS\Domain\Tenant\Models\Organization;

class UpsertOrganizationAction
{
    public static function execute(OrganizationData $organizationData): Organization
    {
        try {
            $organization = DB::transaction(function () use ($organizationData) {
                $organization = Organization::firstOrNew([
                    'organization_type_id' => $organizationData->type?->id,
                    'name' => $organizationData->name,
                    'email' => $organizationData->email,
                ], [
                    'phone' => $organizationData->phone,
                ]);

                $organization->save();

                return $organization;
            });
        } catch (\Exception $e) {
            throw $e;
        }

        return $organization;
    }
}

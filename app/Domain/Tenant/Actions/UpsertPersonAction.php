<?php

namespace SAAS\Domain\Tenant\Actions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SAAS\Domain\Tenant\DataTransferObjects\PersonData;
use SAAS\Domain\Tenant\Models\Person;

class UpsertPersonAction
{
    public static function execute(PersonData $personData): Person
    {
        try {
            $person = DB::transaction(function () use ($personData) {
                $person = Person::updateOrCreate([
                    'email' => $personData->email,
                ], [
                    'name' => $personData->name,
                    'phone' => $personData->phone,
                ]);

                return $person;
            });
        } catch (\Exception $e) {
            Log::error('Failed upserting person detail.', [$e]);

            throw $e;
        }

        return $person;
    }
}

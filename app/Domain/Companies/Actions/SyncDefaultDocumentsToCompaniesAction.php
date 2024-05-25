<?php

namespace SAAS\Domain\Companies\Actions;

use SAAS\Domain\Companies\Jobs\SyncDefaultDocumentsWithCompanies;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Documents\Models\Document;

class SyncDefaultDocumentsToCompaniesAction
{
    public static function execute(Document $document)
    {
        Company::query()->each(
            fn ($company) => dispatch(new SyncDefaultDocumentsWithCompanies(
                $document,
                $company
            ))
        );
    }
}

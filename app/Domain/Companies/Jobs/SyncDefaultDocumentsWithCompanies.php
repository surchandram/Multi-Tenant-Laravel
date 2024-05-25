<?php

namespace SAAS\Domain\Companies\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Miracuthbert\Multitenancy\Database\TenantDatabaseManager;
use SAAS\Domain\Companies\Models\Company;
use SAAS\Domain\Documents\Actions\SyncDocumentForCompanyAction;
use SAAS\Domain\Documents\DataTransferObjects\DocumentData;
use SAAS\Domain\Documents\Models\Document;

class SyncDefaultDocumentsWithCompanies implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        public readonly Document $document,
        public readonly Company $company,
    ) {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(TenantDatabaseManager $db)
    {
        try {
            // set tenant connection and manager
            $db->createConnection($this->company);

            tenancy()->setTenant($this->company);

            // find matching document in tenant
            $model = Document::whereTitle($this->document->title)
                ->whereTypes([$this->document->type->slug])
                ->where('is_editable', false)
                ->first();

            if ($model) {
                $documentData = DocumentData::fromModel($this->document);

                SyncDocumentForCompanyAction::execute($documentData, $model);
            } else {
                $documentData = DocumentData::fromModel($this->document);

                SyncDocumentForCompanyAction::execute($documentData);
            }

            // purge tenant connection
            $db->purge();

            tenancy()->manager()->clearTenant();
        } catch (\Exception $e) {
            Log::error("Failed syncing document to company database. [Company: {$this->company->id}]", [$e]);
        }
    }
}

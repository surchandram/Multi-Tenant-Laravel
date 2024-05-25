<?php

namespace SAAS\Domain\Tenant\ViewModels;

use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Documents\DataTransferObjects\DocumentData;
use SAAS\Domain\Documents\DataTransferObjects\DocumentTypeData;
use SAAS\Domain\Documents\Models\Document;
use SAAS\Domain\Documents\Models\DocumentType;

class UpsertDocumentViewModel extends ViewModel
{
    public function __construct(
        public readonly ?Document $document = null,
    ) {
        if ($document) {
            $this->document->loadMissing([
                'type',
            ]);
        }
    }

    public function replacementsDummy()
    {
        return [
            'company%' => __('Company (:name)', ['name' => config('app.name')]),
            'owner_name%' => 'Jane Doe',
            'job_address%' => '123 ABC Street, ABC City, ABC',
            'insurance_company%' => 'ABC Insurance',
            'company_name%' => __('Company name (:name)', ['name' => config('app.name')]),
            'date_of_loss%' => now()->copy()->subDays(3)->toFormattedDateString(),
        ];
    }

    public function replacements()
    {
        return collect([
            'company%' => __('Company (:name)', ['name' => request()->tenant()->name]),
            'owner_name%' => 'Owner name',
            'job_address%' => 'Job Address',
            'insurance_company%' => 'Insurance Company',
            'company_name%' => __('Company name (:name)', ['name' => request()->tenant()->name]),
            'date_of_loss%' => 'Date of loss',
        ])->map(fn ($label, $value) => ['value' => $value, 'label' => $label])->values();
    }

    public function documents()
    {
        return DocumentData::collection(
            Document::get()
        );
    }

    public function documentTypes()
    {
        return DocumentTypeData::collection(
            DocumentType::active()->get()
        );
    }

    public function document()
    {
        if (! $this->document) {
            return [];
        }

        return DocumentData::fromModel($this->document);
    }
}

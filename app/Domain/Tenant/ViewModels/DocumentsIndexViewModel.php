<?php

namespace SAAS\Domain\Tenant\ViewModels;

use Illuminate\Http\Request;
use SAAS\App\ViewModels\ViewModel;
use SAAS\Domain\Documents\DataTransferObjects\DocumentData;
use SAAS\Domain\Documents\Filters\DocumentFilters;
use SAAS\Domain\Documents\Models\Document;

class DocumentsIndexViewModel extends ViewModel
{
    public function __construct(
        public readonly ?Request $request = null,
    ) {
    }

    public function documents()
    {
        return DocumentData::collection(
            Document::with([
                'type',
            ])->filter($this->request)->paginate()
        );
    }

    public function filters()
    {
        return DocumentFilters::mappings();
    }
}

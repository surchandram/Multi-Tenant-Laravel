<?php

namespace SAAS\Http\Tenant\Controllers\Documents\Inertia;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Documents\Actions\DestroyDocumentAction;
use SAAS\Domain\Documents\Actions\UpsertDocumentAction;
use SAAS\Domain\Documents\DataTransferObjects\DocumentData;
use SAAS\Domain\Documents\Models\Document;
use SAAS\Domain\Tenant\ViewModels\DocumentsIndexViewModel;
use SAAS\Domain\Tenant\ViewModels\UpsertDocumentViewModel;
use SAAS\Http\Tenant\Requests\Documents\DocumentStoreRequest;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $model = new DocumentsIndexViewModel($request);

        return Inertia::render('tenant/views/documents/Index', compact('model'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new UpsertDocumentViewModel();

        return Inertia::render('tenant/views/documents/Create', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentStoreRequest $request)
    {
        try {
            $document = UpsertDocumentAction::execute(
                DocumentData::fromRequest($request)
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage(), [$e]);

            return redirect()->route('tenant.documents.create')->withErrors([
                'title' => __('Failed saving document.'),
            ]);
        }

        return redirect()->route('tenant.documents.edit', $document)->withSuccess(
            __('Document created successfully.')
        );
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($tenant, Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($tenant, Document $document)
    {
        $model = new UpsertDocumentViewModel($document);

        return Inertia::render('tenant/views/documents/Edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(DocumentStoreRequest $request, $tenant, Document $document)
    {
        if (! $document->isEditable()) {
            return redirect()->route('tenant.documents.edit', $document)->withWarning(__('This document cannot be edited.'));
        }

        try {
            $document = UpsertDocumentAction::execute(
                DocumentData::fromRequest($request), $document
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage(), [$e]);

            return redirect()->route('tenant.documents.edit', $document)
                ->withErrors(array_merge([
                    'title' => __('Failed updating document.'),
                ], config('app.debug', false) ? [
                    'general' => $e->getMessage(),
                ] : [])
                );
        }

        return redirect()->route('tenant.documents.edit', $document)->withSuccess(
            __('Document updated successfully.')
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($tenant, Document $document)
    {
        $title = $document->title;

        if (! DestroyDocumentAction::execute($document)) {
            return redirect()->route('tenant.documents.index')
                ->withError(__('Failed deleting :title', ['title' => $title]));
        }

        return redirect()->route('tenant.documents.index')
            ->withSuccess(__('Deleted :title successfully', ['title' => $title]));
    }
}

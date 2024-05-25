<?php

namespace SAAS\Http\Admin\Controllers\Documents;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\Documents\Actions\Admin\UpsertDocumentAction;
use SAAS\Domain\Documents\Actions\DestroyDocumentAction;
use SAAS\Domain\Documents\DataTransferObjects\DocumentData;
use SAAS\Domain\Documents\Models\Document;
use SAAS\Domain\Documents\ViewModels\Admin\GetDocumentsViewModel;
use SAAS\Domain\Documents\ViewModels\Admin\UpsertDocumentViewModel;
use SAAS\Http\Documents\DocumentStoreRequest;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function index(Request $request)
    {
        $model = new GetDocumentsViewModel($request);

        return Inertia::render('admin/views/documents/Index', compact('model'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function create()
    {
        $model = new UpsertDocumentViewModel();

        return Inertia::render('admin/views/documents/Create', compact('model'));
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

            return redirect()->route('admin.documents.create')->withErrors([
                'title' => __('Failed saving document.'),
            ]);
        }

        return redirect()->route('admin.documents.edit', $document)->withSuccess(
            __('Document created successfully.')
        );
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response
     */
    public function edit(Document $document)
    {
        $model = new UpsertDocumentViewModel($document);

        return Inertia::render('admin/views/documents/Edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(DocumentStoreRequest $request, Document $document)
    {
        try {
            $document = UpsertDocumentAction::execute(
                DocumentData::fromRequest($request), $document
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage(), [$e]);

            return redirect()->route('admin.documents.edit', $document)
                ->withErrors(array_merge([
                    'title' => __('Failed updating document.'),
                ], config('app.debug', false) ? [
                    'general' => $e->getMessage(),
                ] : [])
                );
        }

        return redirect()->route('admin.documents.edit', $document)->withSuccess(
            __('Document updated successfully.')
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        $title = $document->title;

        if (! DestroyDocumentAction::execute($document)) {
            return redirect()->route('admin.documents.index')
                ->withError(__('Failed deleting :title', ['title' => $title]));
        }

        return redirect()->route('admin.documents.index')
            ->withSuccess(__('Deleted :title successfully', ['title' => $title]));
    }
}

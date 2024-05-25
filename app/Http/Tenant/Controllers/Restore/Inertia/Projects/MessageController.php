<?php

namespace SAAS\Http\Tenant\Controllers\Restore\Inertia\Projects;

use SAAS\App\Controllers\Controller;
use SAAS\Domain\Restore\Actions\Threads\PostMessageInProjectThreadAction;
use SAAS\Domain\Threads\Models\Message;
use SAAS\Domain\Threads\Models\Thread;
use SAAS\Http\Threads\Requests\MessageDeleteRequest;
use SAAS\Http\Threads\Requests\MessageStoreRequest;
use SAAS\Http\Threads\Requests\MessageUpdateRequest;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Thread $thread)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MessageStoreRequest $request, Thread $thread)
    {
        $message = $request->postMessageToThread();

        PostMessageInProjectThreadAction::execute($message, $request->tenant());

        if (! $message->isRoot()) {
            return back()->withSuccess(__('tenant.project.message_reply_created'));
        }

        return back()->withSuccess(__('tenant.project.message_created'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Thread $thread, Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(MessageUpdateRequest $request, Thread $thread, Message $message)
    {
        $message = $request->updateThreadMessage();

        return back()->withSuccess(__('tenant.project.message_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(MessageDeleteRequest $request, Thread $thread, Message $message)
    {
        $deleted = $request->deleteThreadMessage();

        if (! $deleted) {
            return back()->withError(__('tenant.project.message_delete_failed'));
        }

        return back()->withSuccess(__('tenant.project.message_deleted'));
    }
}

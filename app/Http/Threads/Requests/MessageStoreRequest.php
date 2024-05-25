<?php

namespace SAAS\Http\Threads\Requests;

use Illuminate\Foundation\Http\FormRequest;
use SAAS\Domain\Threads\Actions\PostNewThreadMessageAction;
use SAAS\Domain\Threads\DataTransferObjects\MessageData;

class MessageStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'body' => ['required', 'string', 'max:5000'],
            'parent_id' => ['nullable', 'exists:tenant.thread_messages,id'],
            'thread_id' => ['present'],
            'user_id' => ['present'],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $thread = $this->thread;

        $this->merge([
            'thread_id' => $thread->id,
            'user_id' => $this->user()?->id,
        ]);
    }

    public function postMessageToThread()
    {
        return PostNewThreadMessageAction::execute(MessageData::fromRequest($this));
    }
}

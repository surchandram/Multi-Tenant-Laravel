<?php

namespace SAAS\Http\Threads\Requests;

use Illuminate\Foundation\Http\FormRequest;
use SAAS\Domain\Threads\Actions\UpdateMessageAction;
use SAAS\Domain\Threads\DataTransferObjects\MessageData;

class MessageUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->user()->isNot($this->message->user)) {
            return false;
        }

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
            'user_id' => $this->user()?->id,
        ]);
    }

    /**
     * Update message.
     *
     * @return \SAAS\Domain\Threads\Models\Message
     */
    public function updateThreadMessage()
    {
        return UpdateMessageAction::execute(MessageData::fromRequest($this), $this->message);
    }
}

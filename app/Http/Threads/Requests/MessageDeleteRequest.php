<?php

namespace SAAS\Http\Threads\Requests;

use Illuminate\Foundation\Http\FormRequest;
use SAAS\Domain\Threads\Actions\DeleteMessageAction;

class MessageDeleteRequest extends FormRequest
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
            //
        ];
    }

    /**
     * Delete message.
     *
     * @return null|bool
     */
    public function deleteThreadMessage()
    {
        return DeleteMessageAction::execute($this->message);
    }
}

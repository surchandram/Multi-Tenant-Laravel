<?php

namespace SAAS\Http\Documents;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DocumentStoreRequest extends FormRequest
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
            'title' => ['required', 'string', 'min:3'],
            'body' => ['required'],
            'type_id' => [
                'required',
                Rule::exists('document_types', 'id')->where('usable', true),
            ],
            'usable' => ['boolean'],
            'is_editable' => ['boolean'],
        ];
    }
}

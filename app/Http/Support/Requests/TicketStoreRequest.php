<?php

namespace SAAS\Http\Support\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Saasplayground\SupportTickets\SupportTickets;

class TicketStoreRequest extends FormRequest
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
            'title' => ['required', 'min:3'],
            'message' => ['required', 'min:10'],
            'priority' => ['required', Rule::in(SupportTickets::getPriorityMap())],
            'labels.*' => ['nullable', Rule::exists(SupportTickets::getLabelsTableName(), 'id')],
            'categories' => ['required', Rule::exists(SupportTickets::getCategoriesTableName(), 'id')],
        ];
    }

    public function attributes()
    {
        return [
            'categories' => 'category',
        ];
    }
}

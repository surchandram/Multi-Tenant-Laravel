<?php

namespace SAAS\Http\Companies\Requests\Teams;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use SAAS\Domain\Teams\Actions\UpsertTeamUserAction;
use SAAS\Domain\Teams\Models\Team;

class TeamUserStoreRequest extends FormRequest
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
            'team_id' => [
                'required',
                'exists:teams,id',
            ],
            'user_id' => [
                'required',
                Rule::exists('company_user', 'user_id')->where('company_id', $this->company->id),
            ],
        ];
    }

    public function addTeamMember(): bool
    {
        $this->validated();

        return UpsertTeamUserAction::execute(
            Team::find($this->validated('team_id')),
            $this->validated('user_id')
        );
    }
}

<?php

namespace App\Modules\CoreModule\Http\Requests;

use App\Enums\REGXEnum;
use InnoAya\Mojura\Core\Request;

class CreateRoleRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $nameRegx = REGXEnum::NAME->value;

        return [
            'name' => "required|string|regex:$nameRegx",
            'description' => '',
            'ability_ids' => 'required|array|min:1',
        ];
    }

    public function messages()
    {
        return [
            'name.regex' => 'Role name has invalid characters',
            'ability_ids.required' => 'Please choose at least one ability for this role',
        ];
    }
}

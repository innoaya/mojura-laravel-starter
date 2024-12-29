<?php

namespace App\Modules\CoreModule\Http\Requests;

use App\Enums\REGXEnum;
use InnoAya\Mojura\Core\Request;

class UpdateRoleRequest extends Request
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
            'name' => "string|regex:$nameRegx",
            'ability_ids' => 'array|min:1',
        ];
    }

    public function messages()
    {
        return [
            'name.regex' => 'Role name has invalid characters',
        ];
    }
}

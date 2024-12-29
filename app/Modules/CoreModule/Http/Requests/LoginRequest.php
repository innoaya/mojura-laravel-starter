<?php

namespace App\Modules\CoreModule\Http\Requests;

use InnoAya\Mojura\Core\Request;

class LoginRequest extends Request
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
        return [
            'identifier' => 'string|required',
            'password' => 'string|required',
        ];
    }
}

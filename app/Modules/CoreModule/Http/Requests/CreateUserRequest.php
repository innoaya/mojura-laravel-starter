<?php

namespace App\Modules\CoreModule\Http\Requests;

use App\Enums\UserStatusEnum;
use Illuminate\Validation\Rules\Enum;
use InnoAya\Mojura\Core\Request;

class CreateUserRequest extends Request
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
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role_id' => 'required|numeric|min:1',
            'email' => 'nullable|email|unique:users',
            'full_name' => 'required|string',
            'country_code' => 'nullable',
            'mobile_number' => 'nullable',
            'avatar' => 'nullable|file|mimes:jpg,jpeg,png|max:1024',
            'status' => [new Enum(UserStatusEnum::class)],
        ];
    }
}

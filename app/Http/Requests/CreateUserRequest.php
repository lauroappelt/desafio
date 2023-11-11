<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'identifier' => 'required|unique:users,identifier',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'user_type' => 'required|in:' . User::USER_COMMON . ',' . User::USER_SHOPKEEPER,
        ];
    }
}

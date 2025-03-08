<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateAdminUser extends FormRequest
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
            'name' => 'nullable|string',
            'email' => 'nullable|email',
            'password' => 'nullable|string'
        ];
    }

    public function messages():array {
        return [
            'id.required' => 'ID is required',
            'id.integer' => 'ID must be an integer',
            'name.string' => 'Name must be a string',
            'email.email' => 'Email is invalid',
            'password.string' => 'Password must be a string'
        ];
    }
}

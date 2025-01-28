<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required|min:6'
        ];
    }

    // public function messages(): array
    // {
    //     return [
    //         'email.required' => 'Email is required',
    //         'email.email' => 'Email is invalid',
    //         'email.exists' => 'Email does not exist',
    //         'password.required' => 'Password is required',
    //         'password.min' => 'Password must be at least 6 characters'
    //     ];
    // }

    // public function failedValidation(Validator $validator)
    // {
    //     throw new HttpResponseException(response()->json([
    //         'status' => 'error',
    //         'errors' => $validator->errors()
    //     ], 422));
    // }
}
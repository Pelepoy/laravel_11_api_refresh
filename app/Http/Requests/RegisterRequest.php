<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|min:6',
            'password' => 'required|string|min:6|confirmed'
        ];
    }

    /**
     * You can also customize the error messages for each rule by overriding the messages method.
     */
    
    // public function messages(): array
    // {
    //     return [
    //         'name.required' => 'Name is required',
    //         'name.max' => 'Name cannot exceed 255 characters',
    //         'email.required' => 'Email is required',
    //         'email.email' => 'Email is invalid',
    //         'email.unique' => 'Email is already taken',
    //         'password.required' => 'Password is required',
    //         'password.min' => 'Password must be at least 6 characters',
    //         'password.confirmed' => 'Passwords do not match'
    //     ];
    // }

    /**
     * You can also customize the error messages for each rule by overriding the messages method.
     */
    
    // public function failedValidation(Validator $validator)
    // {
    //     throw new HttpResponseException(response()->json([
    //         'status' => 'error',
    //         'message' => 'Validation errors',
    //         'errors' => $validator->errors()
    //     ], 422));
    // }
}
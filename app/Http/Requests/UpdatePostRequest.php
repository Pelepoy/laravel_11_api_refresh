<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdatePostRequest extends FormRequest
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
            'title' => 'required|string|max:100',
            'content' => 'required|string'
        ];
    }

    /**
     * You can also customize the error messages for each rule by overriding the messages method.
     */

    // public function messages(): array
    // {
    //     return [
    //         'title.required' => 'Title is required',
    //         'title.min' => 'Title must be at least 3 characters',
    //         'title.max' => 'Title cannot exceed 5 characters hehe',
    //         'content.required' => 'Content is required',
    //         'content.min' => 'Content must be at least 10 characters'
    //     ];
    // }

    // TODO: Implement the failedValidation method as REUSABLE 

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => 'Validation errors',
            'errors' => $validator->errors()
        ], 422));
    }
}
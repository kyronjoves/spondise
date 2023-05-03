<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    protected $stopOnFirstFailure = false;
    
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'password_confirm' => 'required|same:password'
        ];
        return $rules;
    }

    public function messages()
    {
        $messages = [
            'name.reuired' => 'A name is required for the registration.',
            'email.required' => 'An email is required.',
            'email.unique' => 'The email has been used already. Please use another one.',
            'password.required' => 'A password is required.',
            'password.min' => 'You did not meet the minimum required characters.',
            'password_confirm.required' => 'Confirmation password is required.',
            'password_confirm.same' => 'The passwords do not match.'
        ];
        return $messages;
    }
}

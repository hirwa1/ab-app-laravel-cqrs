<?php

namespace App\Ab\User\Request;

use Illuminate\Foundation\Http\FormRequest;

class PasswordResetFormRequest extends FormRequest
{
 
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255'],
        ];
    }
}

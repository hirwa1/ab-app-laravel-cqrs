<?php

namespace App\Ab\Employee\Request;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeNewFormRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [


            'name' => 'required|string',
            'email' => 'required|email',
            'phoneNumber' => 'required|string',
            'address' => 'nullable|string',
            'position' => 'nullable|string',
            'department' => 'nullable|string',
            'salary' => 'nullable|string',
            'status' => 'nullable|string',

        ];
    }
}

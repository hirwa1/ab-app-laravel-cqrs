<?php

namespace App\Ab\Employee\Request;

use Illuminate\Foundation\Http\FormRequest;

class  AttendenceNewFormRequest extends FormRequest
{
   
    public function authorize(): bool
    {
        return true;
    }

   
    public function rules(): array
    {
        return [
            'employee_id' => 'required|string',
            'date' => 'required|string',
            'time_in' => 'nullable|string',
            'time_out' => 'nullable|string',
            'total_hours' => 'nullable|string',
            'overtime' => 'nullable|string',
            'remarks' => 'nullable|string',
            'approved_by' => 'nullable|string',
            'approved_at' => 'nullable|string',
        ];
    }
}

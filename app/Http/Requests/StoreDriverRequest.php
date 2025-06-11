<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreDriverRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('manage-drivers');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:drivers,email'],
            'phone_number' => ['required', 'string', 'max:255', 'unique:drivers,phone_number'],
            'license_number' => ['required', 'string', 'max:255', 'unique:drivers,license_number'],
            'license_expiry_date' => ['required', 'date'],
            'photo' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:4096'],
        ];

    }
}

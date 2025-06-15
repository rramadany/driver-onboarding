<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use App\Models\Driver;

class SubmitDriverRequest extends FormRequest
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
        $driver = $this->route('driver');

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:drivers,email,' . $driver->id],
            'phone_number' => ['required', 'string', 'max:255', 'unique:drivers,phone_number,' . $driver->id],
            'license_number' => ['required', 'string', 'max:255', 'unique:drivers,license_number,' . $driver->id],
            'license_expiry_date' => ['required', 'date'],
        ];
        foreach (Driver::FILE_INPUT_MAP as $details) {
            $rules[$details['column']] = ['required', 'string'];
        }
        return $rules;
    }

    protected function prepareForValidation(): void
    {
        // inject the data so that rules() can see it
        $driver = $this->route('driver');
        $data = [
            'name' => $driver->name,
            'email' => $driver->email,
            'phone_number' => $driver->phone_number,
            'license_number' => $driver->license_number,
            'license_expiry_date' => $driver->license_expiry_date?->format('Y-m-d'),
            'photo_path' => $driver->photo_path,
        ];

        foreach (Driver::FILE_INPUT_MAP as $details) {
            $data[$details['column']] = $driver->{$details['column']};
        }

        $this->merge($data);
    }

    public function messages(): array
    {
        $messages = [];
        foreach (Driver::FILE_INPUT_MAP as $details) {
            $messages[$details['column'] . '.required'] = 'The ' . strtolower($details['label']) . ' must be uploaded before submitting.';
        }
        return $messages;

    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use App\Models\Driver;

class UpdateDriverRequest extends FormRequest
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
        $driverId = $this->driver->id;
        $rules = [
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', Rule::unique(Driver::class)->ignore($driverId)],
            'phone_number' => ['nullable', 'string', 'max:255', Rule::unique(Driver::class)->ignore($driverId)],
            'license_number' => ['nullable', 'string', 'max:255', Rule::unique(Driver::class)->ignore($driverId)],
            'license_expiry_date' => ['nullable', 'date'],
        ];

        foreach (array_keys(Driver::FILE_INPUT_MAP) as $inputName) {
            $rules[$inputName] = ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:4096'];
        }

        return $rules;
    }
}

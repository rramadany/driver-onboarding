<?php

namespace App\Http\Requests;

use App\Models\Driver;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

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
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique(Driver::class)->ignore($driverId)],
            'phone_number' => ['required', 'string', 'max:255', Rule::unique(Driver::class)->ignore($driverId)],
            'license_number' => ['required', 'string', 'max:255', Rule::unique(Driver::class)->ignore($driverId)],
            'license_expiry_date' => ['required', 'date'],
            'photo' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:4096'],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DomainCheckRequest extends FormRequest
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
            'domain' => ['required', 'string', 'max:255'],
        ];
    }
    public function prepareForValidation(): void
    {
        if ($this->has('domain')) {
            $this->merge([
                'domain' => strtolower(trim($this->input('domain'))),
            ]);
        }
    }
}

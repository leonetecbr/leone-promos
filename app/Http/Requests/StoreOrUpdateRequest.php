<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrUpdateRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:60'],
            'link' => ['required', 'string'],
            'redirect' => ['nullable', 'in:1'],
            'image' => ['required', 'string'],
            'was' => ['required', 'numeric', 'min:0.01'],
            'for' => ['required', 'numeric', 'min:0'],
            'times' => ['nullable', 'integer', 'min:1'],
            'installments' => ['nullable', 'numeric', 'min:0.01'],
            'code' => ['nullable', 'string', 'max:40'],
            'description' => ['nullable', 'string'],
            'store_id' => ['required', 'integer', 'exists:stores,id'],
            'is_top' => ['nullable', 'in:1'],
            'notification' => ['nullable', 'in:1'],
        ];
    }
}

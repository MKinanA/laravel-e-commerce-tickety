<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array {
        // Use validation for edit and create
        $rules = [
            // 'event_id' => '',
            'name' => 'required|string|max:255|unique:tickets,name,',
            'price' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:1',
            'max_buy' => 'required|integer|min:1'
        ];

        // If edit, remove required
        if ($this->isMethod('put')) {
            $rules['name'] = 'string|max:255|unique:tickets,name,' . $this->route('ticket');
        }

        return $rules;
    }
}

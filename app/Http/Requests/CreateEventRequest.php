<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEventRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:255'],
            'start_date' => ['date_format:Y-m-d'],
            'end_date' => ['required', 'date_format:Y-m-d', 'after:start_date'],
            'start_time' => ['required'],
            'end_time' => ['required',],
            'location' => ['required', 'max:255'],
            'tags' => ['required', ],
            'is_paid_event' => ['sometimes', 'boolean'],
            'ticket_price' => ['required', 'numeric'],
            'number_of_available_tickets' => ['required', 'numeric'],
            'registration_closing_date' => ['required', 'before:end_date'],
            'image' => ['required'],
        ];
    }
}
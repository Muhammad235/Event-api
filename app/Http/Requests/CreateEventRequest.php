<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

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
            'title' => [$this->isPostRequest(), 'string', 'max:100'],
            'description' => [$this->isPostRequest(), 'string', 'max:255'],
            'start_date' => ['date_format:Y-m-d'],
            'end_date' => [$this->isPostRequest(), 'date_format:Y-m-d', 'after:start_date'],
            'start_time' => [$this->isPostRequest(), 'date_format:H:i'],
            'end_time' => [$this->isPostRequest(), 'date_format:H:i', 'after:stat_time'],
            'location' => [$this->isPostRequest(), 'max:255'],
            'tags' => [$this->isPostRequest()],
            'is_paid_event' => ['sometimes', 'boolean'],
            'ticket_price' => [$this->isPostRequest(), 'numeric'],
            'number_of_available_tickets' => [$this->isPostRequest(), 'numeric'],
            'registration_closing_date' => [$this->isPostRequest(), 'before:end_date', 'date_format:Y-m-d'],
            'image' => [$this->isPostRequest(), 'mimes:png,jpg,jpeg,svg', 'max:5048'],
        ];
    }

     private function isPostRequest()
    {
        return request()->isMethod('post') ? $this->isPostRequest() : 'sometimes';
    }
    

}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NoteRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
                return [
                    'name'              => ['bail','required','string', 'max:60', 'min:4', Rule::unique('tags')],
                    'image'             => 'bail|nullable|image|mimes:jpeg,png,jpg|dimensions:max_width=2000,max_height=2000',
                    'expiration_date'   => 'bail|required|date|after_or_equal:today',
                ];
                break;
            case 'PATCH':
            case 'PUT':
                return [
                    'name'              => ['bail','required','string', 'max:60', 'min:4', Rule::unique('tags')->ignore( request('tag') )],
                    'image'             => 'bail|nullable|image|mimes:jpeg,png,jpg|dimensions:max_width=2000,max_height=2000',
                    'expiration_date'   => 'bail|required|date|after_or_equal:today',
                ];
                break;

        }
    }
}

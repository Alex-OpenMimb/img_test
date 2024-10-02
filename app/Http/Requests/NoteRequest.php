<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use App\Traits\ApiResponser;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
class NoteRequest extends FormRequest
{
    use ApiResponser;
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
                    'title'             => ['required','string', 'max:60', 'min:4', Rule::unique('notes')->ignore( request('note') )],
                    'description'       => 'bail|required|min:4',
                    'image'             => 'bail|nullable|image|mimes:jpeg,png,jpg|dimensions:max_width=2000,max_height=2000',
                    'expiration_date'   => [
                        'bail',
                        'nullable',
                        'date','after:today'],
                    'tag_id'=> 'required|exists:tags,id'
                ];
                break;
            default:
                return [];


        }
    }

    public function failedValidation(ValidationValidator $validator) {
        $message = $validator->errors()->all();
        throw new HttpResponseException($this->showMessage($message, 500, false));
    }

}

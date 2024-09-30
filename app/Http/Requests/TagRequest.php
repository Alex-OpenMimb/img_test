<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use App\Traits\ApiResponser;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class TagRequest extends FormRequest
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
                    'name'              => ['bail','required','string', 'max:60', 'min:4', Rule::unique('categories')->whereNull('deleted_at')],
                    'description'       => 'bail|required|string|max:500|min:6',
                    'status'            => 'bail|required|string|min:4',
                ];
                break;
            case 'PUT':
                return [
                    'name'              => ['bail','required','string', 'max:60', 'min:4', Rule::unique('categories')->ignore(request('category')->id)->whereNull('deleted_at')],
                    'description'       => 'bail|required|string|max:500|min:6',
                    'status'            => 'bail|required|string|min:4',
                ];
                break;
            default:
                return [
                    'name'              => 'bail|required|string|max:60|min:4',
                    'description'       => 'bail|required|string|max:500|min:8',
                ];
                break;
        }
    }


    public function failedValidation(ValidationValidator $validator) {
        $message = $validator->errors()->first();
        throw new HttpResponseException($this->showMessage($message, 500, false));
    }
}

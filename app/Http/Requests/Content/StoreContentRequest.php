<?php

namespace App\Http\Requests\Content;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class StoreContentRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:8', 'max:100'],
            'content' => ['required', 'string', 'min:8', 'max:2000'],
            'content_type_id' => ['required', 'integer', 'exists:content_types,id'],
            'content_status_id' => ['required', 'integer', 'exists:content_statuses,id'],
            'author_id' => ['required', 'integer', 'exists:users,id'],
            'location' => [
                'nullable',
                'required_if:content_type_id,2',
                'string',
                'min:8',
                'max:200'
            ],
            'start_date' => [
                'nullable',
                'required_if:content_type_id,2',
                'string',
                'date_format:Y-m-d H:i',
                Rule::date()->after(today())
            ],
            'end_date' => [
                'nullable',
                'required_if:content_type_id,2',
                'string',
                'date_format:Y-m-d H:i',
                'after:start_date'
            ],
            'cover_image' => ['nullable', 'array', 'size:1'],
            'cover_image.*' => ['nullable', 'integer', 'exists:media,id']
        ];
    }

    /**
     * This function throws an exception with a JSON response containing validation errors.
     *
     * @param Validator validator The  parameter is an instance of the Validator class, which
     * is responsible for validating input data against a set of rules. It contains the validation
     * errors that occurred during the validation process.
     */
    public function failedValidation(Validator $validator)
    {
        $response = array(
            'message' => 'Validation errors',
            'errors' => $validator->errors(),
        );

        throw new HttpResponseException(response()->json($response, 422));
    }
}

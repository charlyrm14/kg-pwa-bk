<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreUserRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'min:3', 'max:30'],
            'mother_last_name' => ['nullable', 'string', 'min:3','max:30'],
            'email' => ['required', 'email', 'max:50', 'unique:users,email'],
            'role_id' => ['required', 'integer', 'exists:roles,id'],
            'birthdate' => ['nullable', 'date_format:Y-m-d'],
            'phone_number' => ['nullable', 'integer', 'digits:10'],
            'address' => ['nullable', 'string', 'max:300'],
            'gender_id' => ['required', 'integer', 'exists:genders,id']
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

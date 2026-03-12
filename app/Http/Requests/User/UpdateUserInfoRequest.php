<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class UpdateUserInfoRequest extends FormRequest
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
        $user = $this->route('user');

        return [
            'name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'min:3', 'max:30'],
            'mother_last_name' => ['nullable', 'string', 'min:3','max:30'],
            'username' => [
                'nullable',
                'string',
                'min:4',
                'max:30',
                'alpha_dash',
                Rule::unique('users','username')->ignore($user->id)
            ],
            'role_id' => ['required', 'integer', 'exists:roles,id'],
            'birthdate' => ['required', 'date_format:Y-m-d',]
        ];
    }

    /**
     * The function `prepareForValidation` converts the username input to lowercase if it is not empty.
     */
    protected function prepareForValidation()
    {
        if ($this->username) {
            $this->merge([
                'username' => strtolower($this->username)
            ]);
        }
    }

    /**
     * The function checks if a username has been set and prevents it from being removed once set.
     *
     * @param validator The `` parameter in the `withValidator` function is an instance of
     * the Laravel Validator class. It is used to perform validation on the incoming data. In this
     * case, the `after` method is being used to add custom validation logic that runs after all other
     * validation rules have been checked.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $user = $this->route('user');

            if ($user->username && is_null($this->username)) {
                $validator->errors()->add(
                    'username', 'Username cannot be removed once set.'
                );
            }
        });
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

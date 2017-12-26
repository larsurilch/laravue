<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

abstract class Request extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'errors' => $validator->errors(),
            'success' => false,
            'status' => 'negative',
            'message' => message('MSG004')
        ], 200);

        throw new ValidationException($validator, $response);
    }
}
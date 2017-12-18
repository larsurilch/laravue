<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    public function response(array $errors)
    {
        return response()->json([
            'errors' => $errors,
            'success' => false,
            'status' => 'negative',
            'message' => message('MSG004')
        ]);
    }
}
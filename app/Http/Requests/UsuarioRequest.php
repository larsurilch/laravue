<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'email' => 'required|email|min:3|max:60|unique:usuarios,email',
            'senha' => 'required|min:3|max:60',
            'perfil_id' => 'required|integer',
            'ativo' => 'required|boolean'
        ];

        if($this->method() == 'PATCH' || $this->method() == 'PUT'){
            $rules['email'] .= ',' . $this->id;

            if($this->senha === NULL) {
                unset($rules['senha']);
            }
        }

        return $rules;
    }
}

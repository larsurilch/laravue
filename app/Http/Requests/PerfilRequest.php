<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PerfilRequest extends FormRequest
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
            'descricao' => 'required|min:3|max:60|unique:perfis,descricao',
            'acao_list' => 'required|array'
        ];

        if($this->method() == 'PATCH' || $this->method() == 'PUT'){
            $rules['descricao'] .= ',' . $this->id;
        }

        return $rules;
    }
}

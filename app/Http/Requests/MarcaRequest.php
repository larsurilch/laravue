<?php

namespace App\Http\Requests;

class MarcaRequest extends Request
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
            'descricao' => 'required|min:3|max:60|unique:marcas,descricao'
        ];

        if($this->method() == 'PATCH' || $this->method() == 'PUT'){
            $rules['descricao'] .= ',' . $this->id;
        }

        return $rules;
    }
}

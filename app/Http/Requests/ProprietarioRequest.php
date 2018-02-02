<?php

namespace App\Http\Requests;

class ProprietarioRequest extends Request
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
            'nome' => 'required|min:3|max:150',
            'tipo' => 'required|min:2|max:2',
            'documento' => 'required|min:8|max:25|unique:proprietarios,documento',
            'fone_principal' => 'required|required|min:5|max:18',
            'endereco' => 'required|min:5|max:150',
            'complemento' => 'nullable|min:5|max:80',
            'bairro' => 'required|min:3|max:60',
            'cep' => 'nullable|min:8|max:10',
            'estado_id' => 'required|integer',
            'cidade_id' => 'required|integer'
        ];

        if($this->method() == 'PATCH' || $this->method() == 'PUT') {
            $rules['documento'] .= ',' . $this->id;
        }

        return $rules;
    }
}

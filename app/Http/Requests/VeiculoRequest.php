<?php

namespace App\Http\Requests;

class VeiculoRequest extends Request
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
        return [
            'modelo' => 'required|min:3|max:80',
            'proprietario_id' => 'required|integer',
            'placa' => 'required|min:5|max:10',
            'ano' => 'required|integer',
            'quilometragem' => 'required|min:1|max:45',
            'combustivel' => 'required|min:3|max:15',
            'marca_id' => 'required|integer',
            'data_cotacao' => 'required|date_format:d/m/Y',
            'preco' => 'nullable|numeric',
            'pais_id' => 'required|integer',
            'descricao' => 'required|min:3'
        ];
    }
}

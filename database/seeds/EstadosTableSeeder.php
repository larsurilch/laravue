<?php

use Illuminate\Database\Seeder;
use App\Estado;

class EstadosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Estado::create(array('descricao' => 'Acre', 'sigla' => 'AC'));
        Estado::create(array('descricao' => 'Alagoas', 'sigla' => 'AL'));
        Estado::create(array('descricao' => 'Amapá', 'sigla' => 'AP'));
        Estado::create(array('descricao' => 'Amazonas', 'sigla' => 'AM'));
        Estado::create(array('descricao' => 'Bahia', 'sigla' => 'BA'));
        Estado::create(array('descricao' => 'Ceará', 'sigla' => 'CE'));
        Estado::create(array('descricao' => 'Distrito Federal', 'sigla' => 'DF'));
        Estado::create(array('descricao' => 'Espírito Santo', 'sigla' => 'ES'));
        Estado::create(array('descricao' => 'Goiás', 'sigla' => 'GO'));
        Estado::create(array('descricao' => 'Maranhão', 'sigla' => 'MA'));
        Estado::create(array('descricao' => 'Mato Grosso', 'sigla' => 'MT'));
        Estado::create(array('descricao' => 'Mato Grosso do Sul', 'sigla' => 'MS'));
        Estado::create(array('descricao' => 'Minas Gerais', 'sigla' => 'MG'));
        Estado::create(array('descricao' => 'Pará', 'sigla' => 'PA'));
        Estado::create(array('descricao' => 'Paraíba', 'sigla' => 'PB'));
        Estado::create(array('descricao' => 'Paraná', 'sigla' => 'PR'));
        Estado::create(array('descricao' => 'Pernambuco', 'sigla' => 'PE'));
        Estado::create(array('descricao' => 'Piauí', 'sigla' => 'PI'));
        Estado::create(array('descricao' => 'Rio de Janeiro', 'sigla' => 'RJ'));
        Estado::create(array('descricao' => 'Rio Grande do Norte', 'sigla' => 'RN'));
        Estado::create(array('descricao' => 'Rio Grande do Sul', 'sigla' => 'RS'));
        Estado::create(array('descricao' => 'Rondônia', 'sigla' => 'RO'));
        Estado::create(array('descricao' => 'Roraima', 'sigla' => 'RR'));
        Estado::create(array('descricao' => 'Santa Catarina', 'sigla' => 'SC'));
        Estado::create(array('descricao' => 'São Paulo', 'sigla' => 'SP'));
        Estado::create(array('descricao' => 'Sergipe', 'sigla' => 'SE'));
        Estado::create(array('descricao' => 'Tocantins', 'sigla' => 'TO'));
    }
}

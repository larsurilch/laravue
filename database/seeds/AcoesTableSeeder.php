<?php

use Illuminate\Database\Seeder;
use App\Acao;

class AcoesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Acao::create(['nome' => 'Acesso total do sistema', 'metodo' => '*', 'ordem' => 1]);

        Acao::create(['nome' => 'Listagem de países', 'metodo' => 'paises.index', 'ordem' => 2]);
        Acao::create(['nome' => 'Listagem de Estados', 'metodo' => 'estados.index', 'ordem' => 3]);
        Acao::create(['nome' => 'Listagem de cidades', 'metodo' => 'cidades.index', 'ordem' => 4]);

        Acao::create(['nome' => 'Listagem de marcas', 'metodo' => 'marcas.index', 'ordem' => 5]);
        Acao::create(['nome' => 'Adicionar marca', 'metodo' => 'marcas.create', 'ordem' => 6]);
        Acao::create(['nome' => 'Alterar marca', 'metodo' => 'marcas.show|marcas.update', 'ordem' => 7]);
        Acao::create(['nome' => 'Excluir marca', 'metodo' => 'marcas.destroy', 'ordem' => 8]);

        Acao::create(['nome' => 'Listagem de proprietários', 'metodo' => 'proprietarios.index', 'ordem' => 9]);
        Acao::create(['nome' => 'Adicionar proprietário', 'metodo' => 'proprietarios.create', 'ordem' => 10]);
        Acao::create(['nome' => 'Alterar proprietário', 'metodo' => 'proprietarios.update', 'ordem' => 11]);
        Acao::create(['nome' => 'Detalhar proprietário', 'metodo' => 'proprietarios.show', 'ordem' => 12]);
        Acao::create(['nome' => 'Excluir proprietário', 'metodo' => 'proprietarios.destroy', 'ordem' => 13]);

        Acao::create(['nome' => 'Listagem de veículos', 'metodo' => 'veiculos.index', 'ordem' => 14]);
        Acao::create(['nome' => 'Adicionar veículo', 'metodo' => 'veiculos.create', 'ordem' => 15]);
        Acao::create(['nome' => 'Alterar veículo', 'metodo' => 'veiculos.update', 'ordem' => 16]);
        Acao::create(['nome' => 'Detalhar veículo', 'metodo' => 'veiculos.show', 'ordem' => 17]);
        Acao::create(['nome' => 'Excluir veículo', 'metodo' => 'veiculos.destroy', 'ordem' => 18]);

        Acao::create(['nome' => 'Listagem de perfis', 'metodo' => 'perfis.index', 'ordem' => 19]);
        Acao::create(['nome' => 'Adicionar perfil', 'metodo' => 'perfis.create', 'ordem' => 20]);
        Acao::create(['nome' => 'Alterar perfil', 'metodo' => 'perfis.show|perfis.update', 'ordem' => 21]);
        Acao::create(['nome' => 'Excluir perfil', 'metodo' => 'perfis.destroy', 'ordem' => 22]);

        Acao::create(['nome' => 'Listagem de usuários', 'metodo' => 'usuarios.index', 'ordem' => 23]);
        Acao::create(['nome' => 'Adicionar usuário', 'metodo' => 'usuarios.create', 'ordem' => 24]);
        Acao::create(['nome' => 'Alterar usuário', 'metodo' => 'usuarios.show|usuarios.update', 'ordem' => 25]);
        Acao::create(['nome' => 'Excluir usuário', 'metodo' => 'usuarios.destroy', 'ordem' => 26]);
    }
}

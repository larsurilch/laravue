<?php

use Illuminate\Database\Seeder;
use App\Usuario;

class UsuariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Usuario::create([
            'email' => 'larsurilch@zipmail.com.br',
            'senha' => '123456',
            'perfil_id' => 1,
            'ativo' => 1
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;
use App\Perfil;

class PerfisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $perfil = Perfil::create(array(
            'descricao' => 'Administrador'
        ));

        $perfil->acoes()->sync([1]);
    }
}

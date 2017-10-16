<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(PaisesTableSeeder::class);
         $this->call(EstadosTableSeeder::class);
         $this->call(CidadesTableSeeder::class);
    }
}

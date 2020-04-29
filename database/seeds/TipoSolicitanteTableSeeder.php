<?php

use Illuminate\Database\Seeder;

class TipoSolicitanteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_solicitante')->insert([
            'tipo_solicitante_descricao' => "Associado",
            'tipo_solicitante_status' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('tipo_solicitante')->insert([
            'tipo_solicitante_descricao' => "Empregado FIPECq Vida",
            'tipo_solicitante_status' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('tipo_solicitante')->insert([
            'tipo_solicitante_descricao' => "Parceiro",
            'tipo_solicitante_status' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('tipo_solicitante')->insert([
            'tipo_solicitante_descricao' => "Visitante",
            'tipo_solicitante_status' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}

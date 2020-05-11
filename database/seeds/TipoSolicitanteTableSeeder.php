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
        DB::table('internet.FV_OUV_TIPO_SOLICITANTE')->insert([
            'DESCRICAO' => "Associado",
            'STATUS' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('internet.FV_OUV_TIPO_SOLICITANTE')->insert([
            'DESCRICAO' => "Empregado FIPECq Vida",
            'STATUS' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('internet.FV_OUV_TIPO_SOLICITANTE')->insert([
            'DESCRICAO' => "Parceiro",
            'STATUS' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('internet.FV_OUV_TIPO_SOLICITANTE')->insert([
            'DESCRICAO' => "Visitante",
            'STATUS' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}

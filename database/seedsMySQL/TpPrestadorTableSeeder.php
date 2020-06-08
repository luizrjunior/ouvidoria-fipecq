<?php

use Illuminate\Database\Seeder;

class TpPrestadorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tiposPrestadores = [
            [
                'descricao' => "FIPECq",
                'status' => true
            ],
            [
                'descricao' => "Saúde",
                'status' => true
            ],
            [
                'descricao' => "Odontologia",
                'status' => true
            ],
        ];

        foreach ($tiposPrestadores as $tipoPrestador) {
            $this->command->info('Inserindo Tipo de Prestador: ' . $tipoPrestador['descricao']);
            DB::table('fv_ouv_tp_prestador')->insert([
                'descricao' => $tipoPrestador['descricao'], 
                'status' => $tipoPrestador['status'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

    }

}

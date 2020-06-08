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
        $tiposSolicitantes = [
            ['descricao' => "Associado", 'status' => true],
            ['descricao' => "Empregado FIPECq Vida", 'status' => true],
            ['descricao' => "Parceiro", 'status' => true],
            ['descricao' => "Visitante", 'status' => true],
        ];

        foreach ($tiposSolicitantes as $tipoSolicitante) {
            $this->command->info('Inserindo Tipo de Solicitante: ' . $tipoSolicitante['descricao']);
            DB::table('fv_ouv_tipo_solicitante')->insert([
                'descricao' => $tipoSolicitante['descricao'],
                'status' => $tipoSolicitante['status'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

    }
    
}

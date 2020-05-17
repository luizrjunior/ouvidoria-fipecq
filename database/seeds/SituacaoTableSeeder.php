<?php

use Illuminate\Database\Seeder;

class SituacaoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $situacaoes = [
            ['descricao' => "Nova", 'status' => true],
            ['descricao' => "Em Análise", 'status' => true],
            ['descricao' => "Concluída", 'status' => true],
        ];

        foreach ($situacaoes as $situacao) {
            $this->command->info('Inserindo Situação: ' . $situacao['descricao']);
            DB::table('fv_ouv_tipo_solicitante')->insert([
                'descricao' => $situacao['descricao'],
                'status' => $situacao['status'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

    }
    
}

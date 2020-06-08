<?php

use Illuminate\Database\Seeder;

class CanalAtendimentoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $canaisAtendimentos = [
            [
                'descricao' => "Site",
                'status' => true
            ],
            [
                'descricao' => "Telefone",
                'status' => true
            ],
            [
                'descricao' => "E-mail",
                'status' => true
            ],
            [
                'descricao' => "Presencial",
                'status' => true
            ],
        ];

        foreach ($canaisAtendimentos as $tipoPrestador) {
            $this->command->info('Inserindo Canal de Atendimento: ' . $tipoPrestador['descricao']);
            DB::table('internet.fv_ouv_canal_atendimento')->insert([
                'descricao' => $tipoPrestador['descricao'], 
                'status' => $tipoPrestador['status'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

    }

}

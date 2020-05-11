<?php

use Illuminate\Database\Seeder;

class TipoSolicitacaoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('internet.FV_OUV_TIPO_SOLICITACAO')->insert([
            'NOME' => "RECLAMAÇÃO",
            'DESCRICAO' => "Relatar insatisfação com ações e serviços prestados",
            'ICONE' => "far fa-thumbs-down",
            'COR' => "warning",
            'SLA' => 1,
            'STATUS' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('internet.FV_OUV_TIPO_SOLICITACAO')->insert([
            'NOME' => "SUGESTÃO",
            'DESCRICAO' => "Propor ações úties para melhoria da gestão",
            'ICONE' => "far fa-comment-alt",
            'COR' => "info",
            'SLA' => 1,
            'STATUS' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('internet.FV_OUV_TIPO_SOLICITACAO')->insert([
            'NOME' => "ELOGIO",
            'DESCRICAO' => "Propor ações úties para melhoria da gestão",
            'ICONE' => "far fa-thumbs-up",
            'COR' => "success",
            'SLA' => 1,
            'STATUS' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('internet.FV_OUV_TIPO_SOLICITACAO')->insert([
            'NOME' => "SOLICITAÇÃO",
            'DESCRICAO' => "Requerer informações ou esclarecimento de dúvidas",
            'ICONE' => "far fa-hand-point-up",
            'COR' => "secondary",
            'SLA' => 1,
            'STATUS' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        
        DB::table('internet.FV_OUV_TIPO_SOLICITACAO')->insert([
            'NOME' => "DENÚNCIA",
            'DESCRICAO' => "Apontar falhas na gestão ou no atendimento recebido",
            'ICONE' => "fas fa-bullhorn",
            'COR' => "danger",
            'SLA' => 1,
            'STATUS' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}

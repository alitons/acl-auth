<?php

namespace Acl\Auth\Console\Commands;

use Acl\Auth\Models\Orgao;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class Orgaos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'acl:orgaos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincroniza os órgãos cadastrados no ACL com os órgãos cadastrados no sistema de planejamento.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // CONECTA A API DO ACL
        $url = env('ACL_URL') . '/api/sync/orgaos/' . env('URL_ACESSO');
        $resposta = Http::post($url);
        $dados = $resposta->json();

        // PERCORRE TODOS OS ÓRGAOS RETORNADOS PELO ACL
        foreach($dados['orgaos'] as $orgao) {
            // ATUALIZA OU CRIA O ÓRGÃO
            Orgao::updateOrCreate([
                'id_orgao' => $orgao['orgao_sistema_id']
            ],
            [
                'orgao' => @$orgao['descricao_orgao'] ?? null,
                'sigla_orgao' => @$orgao['sigla_orgao'] ?? null,
                'cnpj' => @$orgao['cnpj'] ?? null,
            ]);
        }

        $this->info('Órgãos importadas com sucesso.');
    }
}

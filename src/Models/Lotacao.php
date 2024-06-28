<?php

namespace Acl\Auth\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lotacao extends Model
{
    use HasFactory;

    protected $table = 'lotacoes';
    protected $primaryKey = 'id_lotacao';

    protected $timestamps = false;

    protected $fillable = [
        'id_lotacao',
        'id_orgao',
        'nome_lotacao',
        'sigla_lotacao',
        'tipo_lotacao',
        'id_lotacao_pai',
    ];

    /* RELACIONA A LOTAÇÃO A UM ÓRGÃO */
    public function orgao(): object
    {
        return $this->belongsTo(Orgao::class, 'id_orgao');
    }

    /* FUNÇÕES DO ESCOPO DA CONSULTA */

    // FAZ A BUSCA POR UMA LOTAÇÃO ESPECIFICA
    public function scopeSearch($query, $search): object
    {
        // VERIFICA SE UM TERMO DE BUSCA FOI INFORMADO
        // SE NÃO FOI INFORMADO FINALIZA O METHODO
        if(!$search) return $query;

        // CASO TENHA UM TERMO A SER BUSCA
        // ADICIONA AO ESCOPO DA CONSULTA A BUSCA PELO TERMO
        return $query->where('nome_lotacao', 'ILIKE', "%{$search}%")
        ->orWhere('sigla_lotacao', 'ILIKE', "%{$search}%");
    }

    // FILTRO POR ÓRGÃO
    public function scopeOrgao($query, $orgao): object
    {
        // VERIFICA SE FOI INFORMADO UM ÓRGÃO
        // SE NÃO FOI DEFINIDO UM ÓRGÃO FINALIZA O METHODO
        if(!$orgao) return $query;

        // CASO TENHA SIDO INFORMADO UM ÓRGÃO
        // ADICIONA A CONSULTA A CONDIÇÃO
        return $query->where('id_orgao', $orgao);
    }
    /* FIM DAS FUNÇÕES DE ESCOPO DA CONSULTA */
}

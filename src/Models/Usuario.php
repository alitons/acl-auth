<?php

namespace Acl\Auth\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'nome',
        'cpf',
        'nivel',
        'email',
        'email_funcional',
        'foto',
    ];

    protected $appends = [
        'apelido',
        'orgao_atual',
        'lotacao_atual'
    ];

    public function getApelidoAttribute()
    {
        $nome = explode(' ', strtr(trim($this->nome), ['  ' => ' ']));
        return $nome[0] . ( count($nome) > 1 ? ' ' . end($nome) : '');
    }

    public function getOrgaoAtualAttribute()
    {
        return Orgao::find(session('user')['orgao_atual'] ?? 0);
    }

    public function getLotacaoAtualAttribute()
    {
        return Lotacao::find(session('user')['lotacao_atual'] ?? 0);
    }
}

<?php

namespace Acl\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Orgao extends Model
{
    use HasFactory;

    protected $table = "orgaos";
    protected $primaryKey = "id_orgao";

    protected $timestamps = false;

    protected $fillable = [
        'id_orgao',
        'sigla_orgao',
        'orgao',
        'cnpj',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrcamentoItem extends Model
{
    use HasFactory;

    protected $table = 'orcamento_itens';

    protected $fillable = [
        'id',
        'id_orcamento',
        'titulo',
        'qtd',
        'valor_un'
    ];

    public $timestamps = false;
}

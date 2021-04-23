<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orcamento extends Model
{
    use HasFactory;

    protected $table = 'orcamentos';

    protected $fillable = [
        'id',
        'protocolo',
        'responsavel',
        'solicitante',
        'email',
        'telefone',
        'inicio',
        'previsao',
        'prioridade',
        'status',
        'pedido',
        'nota_fiscal',
        'valor_total',
        'pagamento',
        'obs',
        'created_at',
        'updated_at'
    ];

    public function itens()
    {
        return $this->hasMany(OrcamentoItem::class, 'id_orcamento', 'id');
    }
}

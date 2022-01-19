<?php
namespace App\Services;

use App\Mail\OrcamentoMail;
use App\Models\{
    Orcamento,
    OrcamentoItem,
    Parametro
};
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ParametrosService{

    
    public function formatParams(){
        $parametro = new Parametro;
        $parametros = $parametro->all();

        $out = [];
        foreach($parametros as $param){
            $out[$param->operacao][$param->atributo] = $param->valor;
        }
        return $out;
    }

}
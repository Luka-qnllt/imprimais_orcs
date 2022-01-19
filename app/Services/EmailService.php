<?php
namespace App\Services;

use App\Mail\OrcamentoMail;
use App\Models\{
    Orcamento,
    OrcamentoItem
};
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class EmailService{

    /**
     * send a mail
     */
    public function sendMail(Orcamento $orcamento, $data){
        return Mail::send(new OrcamentoMail($orcamento, $data));
    }

}
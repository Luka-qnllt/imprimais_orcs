<?php

namespace App\Http\Controllers;

use App\Models\Orcamento;
use App\Models\Parametro;
use App\Services\EmailService;
use App\Services\ParametrosService;
use Exception;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function sendMail(Request $request, Orcamento $orcamento){

        try{

            $email = $request->input('email');
            $message = $request->input('message');
            
            if(empty($email))
                throw new Exception('Insira um endereço de email');

            $data = [
                'email' => $email,
                'message' => $message
            ];

            $emailService = new EmailService;
            $sended = $emailService->sendMail($orcamento, $data);
            $out = ['status' => true, 'data' => $sended];

        } catch (Exception $e){
            $out = ['status' => false, 'msg' => $e->getMessage()];
        }
        return response()->json($out);
    }

    public function editMail(Orcamento $orcamento, Request $request){

        $parametrosService = new ParametrosService;
        $parametros = $parametrosService->formatParams();

        return view('archives.email-orcamento', [
            'orc' => $orcamento, 
            'params' => $parametros,
            'data' => [
                'message' => $request->input('message'),
            ],
        ]);
    }
}

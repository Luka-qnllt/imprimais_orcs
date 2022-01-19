<?php

namespace App\Http\Controllers;

use App\Models\Orcamento;
use App\Models\OrcamentoItem;
use App\Models\Parametro;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\{
    OrcamentoService,
    ApiTempOldOrc
};
use Illuminate\Support\Facades\Auth;
use RuntimeException;

class ConfigController extends Controller
{
    private $orcamentoService;
    
    public function __construct(
        OrcamentoService $orcamentoService
    )
    {
        $this->orcamentoService = new OrcamentoService;
    }

    public function index(){
        $parametro = new Parametro;
        $parametros = $parametro->all();
        return view('dashboards.config', [
            'parametros' => $parametros
        ]);
    }

    public function changePass(Request $request){
        
        try{
            
            $password = $request->input('password');
            $confirm_password = $request->input('confirm_password');

            if(empty($password))
                throw new Exception('As senhas não conferem');

            if($password != $confirm_password)
                throw new Exception('As senhas não conferem');            

            if(strlen($password) < 5)
                throw new Exception('Senha muito curta');
            
            $userModel = new User;
        
            $user = $userModel->find(Auth::id());
            $result = $user->update(['password' => bcrypt($password)]);
            
            $out = ['status'=>true, 'data'=>$result];            
        } catch(Exception $e){
            $out = ['status'=>false, 'msg'=>$e->getMessage()];
        }
        return response()->json($out);
    }

    public function changeLogin(Request $request){
        
        try{
            
            $login = $request->input('login');

            if(empty($login))
                throw new Exception('Insira um Login');
            
            if(strlen($login) < 4)
                throw new Exception('Login muito pequeno');

            $userModel = new User;
        
            $user = $userModel->find(Auth::id());
            $result = $user->update(['login' => $login]);
            $out = ['status'=>true, 'data'=>$result];            
        } catch(Exception $e){
            $out = ['status'=>false, 'msg'=>$e->getMessage()];
        }
        return response()->json($out);
    }

    public function updateParametro(Parametro $parametro, Request $request){

        try{
            
            $data = [
                'operacao' => $request->input('operacao'),
                'atributo' => $request->input('atributo'),
                'valor' => $request->input('valor'),
            ];

            $parametro->update($data);

            return redirect('/config');
        } catch (Exception $e){
            return back()->withErrors([ $e->getMessage() ]);
        }
    }
}
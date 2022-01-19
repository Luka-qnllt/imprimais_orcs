<?php

namespace App\Http\Controllers;

use App\Models\Orcamento;
use App\Models\OrcamentoItem;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\{
    OrcamentoService,
    ApiTempOldOrc
};
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class OrcamentoController extends Controller
{
    private $orcamentoService;
    
    public function __construct(
        OrcamentoService $orcamentoService
    )
    {
        $this->orcamentoService = new OrcamentoService;
    }

    public function restorage(){
        $this->orcamentoService->restorage();
        die;
    }

    public function index(){
        return view('dashboards.orcamentos');
    }

    public function save(Request $request){
        
        $valid_data = $request->validate([
            'responsavel' => 'nullable|string',
            'solicitante' => 'nullable|string',
            'email'       => 'nullable|string',
            'telefone'    => 'nullable|string',
            'inicio'      => 'nullable|string',
            'previsao'    => 'nullable|string',
            'prioridade'  => 'nullable|string',
            'status'      => 'nullable|string',
            'pedido'      => 'nullable|string',
            'nota_fiscal' => 'nullable|string',
            'valor_total' => 'nullable|string',
            'pagamento'   => 'nullable|string',
            'obs'         => 'nullable|string',

            //itens
            'item_id'       => 'nullable|array',
            'item_titulo'   => 'nullable|array',
            'item_qtd'      => 'nullable|array',
            'item_valor_un' => 'nullable|array',

            'item_id.*'       => 'nullable|integer',
            'item_titulo.*'   => 'nullable|string',
            'item_qtd.*'      => 'nullable|string',
            'item_valor_un.*' => 'nullable|string',
        ]);

        try{
            DB::beginTransaction();

            $dataOrc = [
                'responsavel' => $valid_data['responsavel'],
                'solicitante' => $valid_data['solicitante'],
                'email'       => $valid_data['email'],
                'telefone'    => $valid_data['telefone'],
                'inicio'      => $valid_data['inicio'],
                'previsao'    => $valid_data['previsao'],
                'prioridade'  => $valid_data['prioridade'],
                'status'      => $valid_data['status'],
                'pedido'      => $valid_data['pedido'],
                'nota_fiscal' => $valid_data['nota_fiscal'],
                'valor_total' => $this->unMaskMoney($valid_data['valor_total']),
                'pagamento'   => $valid_data['pagamento'],
                'obs'         => $valid_data['obs']
            ];

            $created = $this->orcamentoService->create($dataOrc);

            for($i=0; $i<count($valid_data['item_id']); $i++){
                $data_item = [
                    'id_orcamento'  => $created->id,
                    'id'            => $valid_data['item_id'][$i],
                    'titulo'        => $valid_data['item_titulo'][$i],
                    'qtd'           => $valid_data['item_qtd'][$i],
                    'valor_un'      => $this->unMaskMoney($valid_data['item_valor_un'][$i]),
                ];
                $this->orcamentoService->saveItem($data_item);
            }


            $out = ['status'=>true, 'data'=>$created];
            DB::commit();
        } catch(Exception $e){
            $out = ['status'=>false, 'msg'=>$e->getMessage()];
            DB::rollBack();
        }
        return response()->json($out);
    }

    public function filter(Request $request){
        $filters = [
            'inicio' => $request->input('inicio'),
            'status' => $request->input('status'),
            'pagamento' => $request->input('pagamento'),
            'prioridade' => $request->input('prioridade'),
        ];

        $orcs = $this->orcamentoService->filter($filters);
        $out = ['status'=>true, 'data'=>$orcs];
        return response()->json($out);
    }

    public function get(Orcamento $orcamento){
        $orcamento->itens;
        $out = ['status'=>true, 'data'=>$orcamento];
        return response()->json($out);
    }

    public function update(Orcamento $orcamento, Request $request){
        $valid_data = $request->validate([
            'responsavel' => 'nullable|string',
            'solicitante' => 'nullable|string',
            'email'       => 'nullable|string',
            'telefone'    => 'nullable|string',
            'inicio'      => 'nullable|string',
            'previsao'    => 'nullable|string',
            'prioridade'  => 'nullable|string',
            'status'      => 'nullable|string',
            'pedido'      => 'nullable|string',
            'nota_fiscal' => 'nullable|string',
            'valor_total' => 'nullable|string',
            'pagamento'   => 'nullable|string',
            'obs'         => 'nullable|string',

            //itens
            'item_id'  => 'nullable|array',
            'item_titulo'     => 'nullable|array',
            'item_qtd'      => 'nullable|array',
            'item_valor_un' => 'nullable|array',

            'item_id.*'  => 'nullable|integer',
            'item_titulo.*'     => 'nullable|string',
            'item_qtd.*'      => 'nullable|string',
            'item_valor_un.*' => 'nullable|string',
        ]);

        try{
            DB::beginTransaction();

            $dataOrc = [
                'responsavel' => $valid_data['responsavel'],
                'solicitante' => $valid_data['solicitante'],
                'email'       => $valid_data['email'],
                'telefone'    => $valid_data['telefone'],
                'inicio'      => $valid_data['inicio'],
                'previsao'    => $valid_data['previsao'],
                'prioridade'  => $valid_data['prioridade'],
                'status'      => $valid_data['status'],
                'pedido'      => $valid_data['pedido'],
                'nota_fiscal' => $valid_data['nota_fiscal'],
                'valor_total' => $this->unMaskMoney($valid_data['valor_total']),
                'pagamento'   => $valid_data['pagamento'],
                'obs'         => $valid_data['obs'],
            ];

            $updated = $this->orcamentoService->update($orcamento, $dataOrc);

            for($i=0; $i<count($valid_data['item_id']); $i++){
                $data_item = [
                    'id_orcamento'  => $orcamento->id,
                    'id'            => $valid_data['item_id'][$i],
                    'titulo'        => $valid_data['item_titulo'][$i],
                    'qtd'           => $valid_data['item_qtd'][$i],
                    'valor_un'      => $this->unMaskMoney($valid_data['item_valor_un'][$i]),
                ];
                $this->orcamentoService->saveItem($data_item);
            }

            $out = ['status'=>true, 'data'=>$updated];
            DB::commit();
        } catch(Exception $e){
            $out = ['status'=>false, 'msg'=>$e->getMessage()];
            DB::rollBack();
        }
        return response()->json($out);
    }

    public function delete(Orcamento $orcamento){
        try{
            DB::beginTransaction();
            $deleted = $this->orcamentoService->delete($orcamento);
            $out = ['status'=>true, 'data'=>$deleted];
            DB::commit();
        } catch (Exception $e){
            $out = ['status'=>false, 'msg'=>$e->getMessage()];
            DB::rollBack();            
        }
        return response()->json($out);
    }

    public function deleteItem(OrcamentoItem $item){
        $deleted = $this->orcamentoService->deleteItem($item);
        $out = ['status'=>true, 'data'=>$deleted];
        return response()->json($out);
    }

    private function unMaskMoney($str){
        $str = str_replace('.', '', $str);
        $str = str_replace(',', '.', $str);
        return floatval($str);

    }
}


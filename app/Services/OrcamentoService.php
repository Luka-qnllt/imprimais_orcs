<?php
namespace App\Services; 

use App\Models\{
    Orcamento,
    OrcamentoItem
};
use Exception;
use Illuminate\Support\Facades\DB;

class OrcamentoService{
    
    private $orcamento;
    private $orcamento_item;

    public function __construct(){
        $this->orcamento = new Orcamento();
        $this->orcamento_item = new OrcamentoItem();
    }

    public function create($data){
        $created = $this->orcamento->create($data);
        return $created;
    }

    public function update(Orcamento $orcamento, $data){
        return $orcamento->update($data);
    }

    public function delete(Orcamento $orcamento){
        $this->deleteItemByOrcamento($orcamento);
        return $orcamento->delete();
    }

    public function restorage(){
        try{
            DB::beginTransaction();
        
                $oldDB = new ApiTempOldOrc;
                $oldOrcs = $oldDB->getAllOrcs();
        
                foreach($oldOrcs as $OldOrc){

                    $data = [
                        'id'          => $OldOrc['idproduct'],
                        'solicitante' => $OldOrc['desproduct'],
                        'responsavel' => $OldOrc['vlprice'],
                        'solicitante' => $OldOrc['vlprice'],
                        'email'       => $OldOrc['vlwidth'],
                        'telefone'    => $OldOrc['vlheight'],
                        'inicio'      => !empty($OldOrc['vllength']) ? $OldOrc['vllength'] : null, 
                        'previsao'    => $OldOrc['vlweight'],
                        'prioridade'  => $this->formatDataOld($OldOrc['prioridade']),
                        'status'      => $this->formatDataOld($OldOrc['stats']),
                        'pedido'      => $OldOrc['desurl'],
                        'nota_fiscal' => $OldOrc['nota'],
                        'valor_total' => $OldOrc['price'],
                        'pagamento'   => $OldOrc['pago'] == 'Pago' ? 'PG' : 'PD',
                        'obs'         => $OldOrc['desction'],
                        'protocolo'   => $OldOrc['cod'],
                    ];
                    
                    $nweOrc = $this->create($data);

                    $itensOld = $oldDB->getItensByCod($OldOrc['cod']);
                    foreach($itensOld as $item){
                        $data_item = [
                            'id_orcamento'  => $nweOrc->id,
                            'titulo'        => $item['item'],
                            'qtd'           => $item['qtd'],
                            'valor_un'      => $item['valor'],
                        ];
                        $this->createItem($data_item);
                        echo('ITEM CRIADO <br>');
                    }

                    echo "\n ORÇAMENTO CRIADO <br>";
                }

                
        
            DB::commit(); 
        } catch(Exception $e){
            echo "\n ERROR {$e->getMessage()}";
            DB::rollBack();
        }
    }

    public function filter($filters){

        $query = $this->orcamento->orderBy('id', 'desc');

        foreach($filters as $key => $value){
            if(!empty($value))
                $query->where($key, $value);
        }
        
        $result = $query->get();

        return $result;
    }

    private function formatDataOld($str){
        if(empty($str)) return '';
        $str = explode(')', $str);
        if(empty($str[1])) return '';
        $str = str_replace('(', '', $str[0]);
        return $str;
    }

    //ITENS

    public function deleteItemByOrcamento(Orcamento $orcamento){
        $itens = $orcamento->itens;
        foreach($itens as $item){
            $this->deleteItem($item);
        }
        return true;
    }

    public function deleteItem(OrcamentoItem $item){
        return $item->delete();
    }

    public function createItem($data){
        $created = $this->orcamento_item->create($data);
        return $created;
    }

    public function updateItem(OrcamentoItem $item, $data){
        $updated = $item->update($data);
        return $updated;
    }

    public function getItemById($id){
        return $this->orcamento_item->find($id);
    }

    public function saveItem($data){
        if(empty($data['id'])){
            $saved = $this->createItem($data);
        } else {
            $item = $this->getItemById($data['id']);
            $saved = $this->updateItem($item, $data);
        }
        return $saved;
    }
}
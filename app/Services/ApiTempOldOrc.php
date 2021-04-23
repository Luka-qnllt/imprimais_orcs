<?php

namespace App\Services;
use \PDO;

class ApiTempOldOrc extends \PDO
{
    private $con;

    public function __construct(){
        $this->con = new PDO("mysql:host=64.37.59.74;dbname=imprimaisdigital_db_orc", "imprimaisdigital_orc_old", "lcq@1158");
    }

    public function getAllOrcs(){
        $con = $this->con;

        $stm = $con->prepare("SELECT * FROM imprimaisdigital_db_orc.tb_products;");
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllItens(){
        $con = $this->con;

        $stm = $con->prepare("SELECT * FROM imprimaisdigital_db_orc.tb_itens;");
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getItensByCod($cod){
        $con = $this->con;

        $stm = $con->prepare("SELECT * FROM imprimaisdigital_db_orc.tb_itens where cod = '{$cod}';");
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
<?php

require_once __DIR__.'/../db/PDOFactory.php';
require_once __DIR__.'/../class/Produto.php';

class ProdutoDAO {

    function inserir(Produto $p)
    {

    }
    function buscaPorId($id)
    {
        $con = PDOFactory::getConexao();
        $stmt = $con->prepare("Select nome, preco from produtos where id = :id");
        
    }

    function atualizar(Produto $pnovo)
    {
        
    }

    public static function listar()
    {
        $con = PDOFactory::getConexao();
        $result = $con->query('Select id, nome, preco from produtos');
        //$stmt->execute();
        $data = [];
        //$result = $con->query($stmt);
        foreach($result as $r) {
            $p = new Produto($r['id'],
                             $r['nome'],
                             $r['preco']);
            $data[] = $p;
        }

        return $data;
        


    }

    function deletar($id)
    {
        
    }




}
<?php

require_once __DIR__.'/../db/PDOFactory.php';
require_once __DIR__.'/../class/Produto.php';

class ProdutoDAO {

    function inserir(Produto $p)
    {
        $con = PDOFactory::getConexao();
        $stmt = $con->prepare('INSERT INTO produtos (nome,preco) VALUES (:nome,:preco)');
        $stmt->bindParam('nome',$p->nome);
        $stmt->bindParam('preco',$p->preco);
        $stmt->execute();
        $con->lastInsertId();

    }
    public function buscaPorId($id)
    {
        $con = PDOFactory::getConexao();
        $stmt = $con->prepare("SELECT id, nome, preco FROM produtos WHERE id = :id");
        $stmt->bindParam('id',$id);
        $stmt->execute();
        $resultSet = $stmt->fetch();
        return new Produto($resultSet['id'],$resultSet['nome'],$resultSet['preco']);
   
    }

    function atualizar(Produto $pnovo)
    {
        $con = PDOFactory::getConexao();
        $stmt = $con->prepare("UPDATE produtos SET nome = :nome, preco = :preco WHERE id = :id");
        $stmt->bindParam('id',$pnovo->id);
        $stmt->bindParam('nome',$pnovo->nome);
        $stmt->bindParam('preco',$pnovo->preco);
        $stmt->execute();

    }

    public static function listar()
    {
        $con = PDOFactory::getConexao();
        $stmt = $con->prepare('Select id, nome, preco from produtos');
        $stmt->execute();
        $data = [];
        $resultSet = $stmt->fetchAll();
        foreach($resultSet as $r) {
            $data[] = new Produto($r['id'],
                                  $r['nome'],
                                  $r['preco']);
        }
        return $data;
    }

    public static function deletar($id)
    {
        $con = PDOFactory::getConexao();
        $stmt = $con->prepare('DELETE FROM produtos WHERE id=:id');
        $stmt->bindParam('id',$id);
        $stmt->execute();
    }




}
<?php
require __DIR__."/db/PDOFactory.php";
require __DIR__."/dao/ProdutoDAO.php";

$pdo = PDOFactory::getConexao();

if($pdo) {
    echo 'Conexão realizada.';
} else {
    echo 'Conexão falhou.';
    //echo $pdo->erroInfo();
}

echo '<h2>Teste db produtos</h2>';

$arrProd = ProdutoDAO::listar();
var_dump($arrProd);


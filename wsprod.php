<?php
include "class/Produto.php";

$produtos = [];

inserir(new Produto(1, "Livro", 42.60));
inserir(new Produto(2, "Caderno", 10.15));
inserir(new Produto(3, "Lápis", 2.10));
inserir(new Produto(4, "Caneta", 3.25));

//var_dump($GLOBALS);

function inserir(Produto $p)
{
    $GLOBALS["produtos"][] = $p;
}

function buscaPorId($id)
{
    foreach($GLOBALS["produtos"] as $produto) {
        if($produto->id == $id)
            return $produto;
    }
}

function atualizar(Produto $pnovo)
{
    foreach($GLOBALS["produtos"] as $i => $produto) {
        if($produto->id == $pnovo->id)
            $GLOBALS["produtos"][$i] = $pnovo;
    }
}

function deletar($id)
{
    foreach($GLOBALS["produtos"] as $i => $produto) {
        if($produto->id == $id)
            unset($GLOBALS["produtos"][$i]);
    }
}

//verificando a chamada de metodo pelo servidor
$metodo = $_SERVER["REQUEST_METHOD"];

switch($metodo){

    case "GET":
        if(!empty($_GET['id'])){
            $id = intval($_GET["id"]);
            $produtos = buscaPorId($id);
        }
        $pjson = json_encode($produtos);
        header("Content-type:application/json"); //o header se prepara para receber um json
        echo $pjson;
    break;

    case "POST":
        //simula uma interface de entrada de dados em json usando o postman
        $djson = file_get_contents("php://input");
        $dados = json_decode($djson);
        $p = new Produto($dados->id, $dados->nome, $dados->preco);
        inserir($p);
        $pjson = json_encode($produtos);
        header("Content-type:application/json");
        header("HTTP/1.1 201 CREATED");
        echo $pjson;
    break;

    case "PUT":
        //simula uma interface de entrada de dados em json usando o postman
        $djson = file_get_contents("php://input");
        $dados = json_decode($djson);
        $p = new Produto($dados->id, $dados->nome, $dados->preco);
        atualizar($p);
        $pjson = json_encode($produtos);
        header("Content-type:application/json");
        header("HTTP/1.1 200 OK");
        echo $pjson;
    break;

    case "DELETE":
        $id = intval($_GET["id"]);
        deletar($id);
        $pjson = json_encode($produtos);
        header("Content-type:application/json"); //o header se prepara para receber um json
        header("HTTP/1.1 200 OK");
        echo $pjson;
    break;

    default:
        header("HTTP/1.1 405 METHOD NOT ALLOWED");
    break;

}
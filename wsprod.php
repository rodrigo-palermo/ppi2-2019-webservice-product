<?php
require_once "class/Produto.php";
require __DIR__."/dao/ProdutoDAO.php";

//OBS.: array deletado e funcoes passadas para dao/ProdutoDAO.php

//verificando a chamada de metodo pelo servidor
$metodo = $_SERVER["REQUEST_METHOD"];

$produtos = ProdutoDAO::listar();


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
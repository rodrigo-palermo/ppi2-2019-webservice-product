<?php
//namespace do slim
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require "vendor/autoload.php";
require "dao/ProdutoDAO.php";

$config = [ //
    'settings' => [
        //'displayErrorDetails' => true,
        //'addContentLengthHeader' => false,  //usar em caso de erro desconhecido
    ]

];

//objeto do slim que será chamado para as requisicoes
//espera a requisicao
$app = new \Slim\App($config);

//refatorar o wsprod.php para utilizar com slim

//substitui o method
//aqui na url o /produtos chama o get
$app->get("/produtos", function(Request $request, Response $response, array $args){
    $produtos = ProdutoDAO::listar();
    $response = $response->withJson($produtos); //converte a lista para json
    $response = $response->withHeader("Content-type","application/json");//passa o cabeçalho
    return $response;

    //como era feito em wsprod.php
    //$pjson = json_encode($produtos);
    //header("Content-type:application/json"); //o header se prepara para receber um json
    //echo $pjson;
}
); 

$app->get("/produtos/{id}", function(Request $request, Response $response, array $args) {
    $id = (int) $args['id'];
    $produtoDAO = new ProdutoDAO();
    $produto = $produtoDAO->buscaPorId($id);
    $response = $response->withJson($produto); //converte a lista para json
    $response = $response->withHeader("Content-type","application/json");//passa o cabeçalho
    return $response;
});

//disponibilizar para  aplicaçao (para ficar escutando as requisicoes)
$app->run();
?>  
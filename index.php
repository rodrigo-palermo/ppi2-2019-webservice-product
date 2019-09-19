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

$app->post("/produtos", function(Request $request, Response $response) {
    $request = json_decode($request->getBody());
    $produtoDAO = new ProdutoDAO();
    $produto = new Produto();
    $produto->nome = $request->nome;
    $produto->preco = $request->preco;
    $produtoDAO->inserir($produto);
});

$app->put("/produtos/{id}", function(Request $request, Response $response, array $args) {
    $request = json_decode($request->getBody());
    $produtoDAO = new ProdutoDAO();
    $produto = new Produto();
    $produto->id = (int) $args['id'];
    $produto->nome = $request->nome;
    $produto->preco = $request->preco;
    $produtoDAO->atualizar($produto);
});

$app->delete("/produtos/{id}", function(Request $request, Response $response, array $args) {
    $id = (int) $args['id'];
    ProdutoDAO::deletar($id);

});

//disponibilizar para  aplicaçao (para ficar escutando as requisicoes)
$app->run();
?>  

<?php

class Produto {
    public $id;
    public $nome;
    public $preco;

    function __construct($id = "", $nome = "", $preco = "")
    { //construtor dinamico - plimorfismo
        $this->id = $id;
        $this->nome = $nome;
        $this->preco = $preco;
       
    }

    function __get($prop)
    {
        return $this->prop;
    }

    function __set($prop, $val)
    {
        $this->prop = $val;
    }

}
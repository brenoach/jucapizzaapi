<?php
class Bebidas{
    private $conn;
    private $tabela ="bebida";
    public $idBebida;
    public $nomeBebida;
    public $tipoBebida;
    public $volume;
    public $valor;

    public function __construct($db) {
        $this->conn = $db;
    }
    function get() {
        // Query SQL para selecionar todos os campos da tabela de pizzas
        $query = "SELECT idBebida, nomeBebida, tipoBebida,volume, valor FROM " . $this->tabela . " ORDER BY valor ASC";
        
 
        // Prepara a query
        $stmt = $this->conn->prepare($query);
 
        // Executa a query
        $stmt->execute();
 
        return $stmt;
    }
}
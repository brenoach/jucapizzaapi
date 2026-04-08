<?php
class Pizza{
    private $conn;
    private $tabela ="pizzas";
    public $idPizza;
    public $nome;
    public $ingredientes;
    public $valor;

    public function __construct($db) {
        $this->conn = $db;
    }
    function read() {
        // Query SQL para selecionar todos os campos da tabela de pizzas
        $query = "SELECT idPizza, nome, ingredientes, valor FROM " . $this->tabela . " ORDER BY valor ASC";
        
 
        // Prepara a query
        $stmt = $this->conn->prepare($query);
 
        // Executa a query
        $stmt->execute();
 
        return $stmt;
    }
}
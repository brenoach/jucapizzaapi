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
    function read() {
        // Query SQL para selecionar todos os campos da tabela de pizzas
        $query = "SELECT 
        idBebida,
        nomeBebida,
        tipoBebida,
        volume, 
        valor 
        FROM " . $this->tabela . " ORDER BY valor ASC";
        
 
        // Prepara a query
        $stmt = $this->conn->prepare($query);
 
        // Executa a query
        $stmt->execute();
 
        return $stmt;
    }
    public function read_single()
    {
        // Cria a consulta
        $query = 'SELECT
        idBebida,
        nomeBebida,
        tipoBebida,
        volume, 
        valor
        FROM
            ' . $this->tabela . ' p
        WHERE
            p.idBebida = ?
        LIMIT 1';
 
        // Prepara a query
        $stmt = $this->conn->prepare($query);
 
        // Vincula o ID
        $stmt->bindParam(1, $this->idBebida);
 
        // Executa a query
        $stmt->execute();
 
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
        // Define as propriedades
        $this->nome = $row['nomeBebida'];
        $this->tipoBebida = $row['tipoBebida'];
        $this->volume = $
        $this->valor = $row['valor'];
    }
}
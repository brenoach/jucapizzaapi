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
        $query = "SELECT 
            idPizza,
            nome,
            ingredientes,
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
            p.idPizza,
            p.nome,
            p.ingredientes,
            p.valor
        FROM
            ' . $this->tabela . ' p
        WHERE
            p.idPizza = ?
        LIMIT 1';
 
        // Prepara a query
        $stmt = $this->conn->prepare($query);
 
        // Vincula o ID
        $stmt->bindParam(1, $this->idPizza);
 
        // Executa a query
        $stmt->execute();
 
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
        // Define as propriedades
        $this->nome = $row['nome'];
        $this->ingredientes = $row['ingredientes'];
        $this->valor = $row['valor'];
    }
    public function create()
    {
        // Query de inserção
        $query = 'INSERT INTO ' . $this->tabela . ' SET nome = :nome, ingredientes = :ingredientes, valor = :valor';
 
        // Preparar a query
        $stmt = $this->conn->prepare($query);
 
        // Limpar os dados
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->ingredientes = htmlspecialchars(strip_tags($this->ingredientes));
        $this->valor = htmlspecialchars(strip_tags($this->valor));
       
        // Vincular os parâmetros
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':ingredientes', $this->ingredientes);
        $stmt->bindParam(':valor', $this->valor);
 
        // Executar a query
        if ($stmt->execute()) {
            return true;
        }    
        return false;
    }

    public function update() {
        // Query de atualização
        $query = 'UPDATE ' . $this->tabela . ' SET nome=:nome, ingredientes=:ingredientes, valor=:valor WHERE idPizza=:id';
 
        // Preparar a query
        $stmt = $this->conn->prepare($query);
 
        // Limpar os dados
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->ingredientes = htmlspecialchars(strip_tags($this->ingredientes));
        $this->valor = htmlspecialchars(strip_tags($this->valor));
        $this->idPizza = htmlspecialchars(strip_tags($this->idPizza));
 
        // Vincular os parâmetros
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':ingredientes', $this->ingredientes);
        $stmt->bindParam(':valor', $this->valor);
        $stmt->bindParam(':id', $this->idPizza);
 
        // Executar a query
        if($stmt->execute()) {
            return true;
        }
     
        return false;
    }
}
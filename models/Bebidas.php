<?php
class Bebidas {
    private $conn;
    private $tabela = "bebida"; // Certifique-se de que no seu banco MySQL a tabela se chama 'bebida' (no singular)

    public $idBebida;
    public $nomeBebida;
    public $tipoBebida;
    public $volume;
    public $valor;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para ler todas as bebidas (O garçom lendo o cardápio inteiro)
    public function read() {
        $query = "SELECT 
            idBebida,
            nomeBebida,
            tipoBebida,
            volume, 
            valor 
        FROM " . $this->tabela . " ORDER BY valor ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }

    // Método para ler uma bebida específica (O garçom buscando o detalhe de um único pedido)
    public function read_single() {
        $query = 'SELECT
            b.idBebida,
            b.nomeBebida,
            b.tipoBebida,
            b.volume, 
            b.valor
        FROM
            ' . $this->tabela . ' b
        WHERE
            b.idBebida = ?
        LIMIT 1';
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->idBebida);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Define as propriedades corrigidas
        $this->nomeBebida = $row['nomeBebida'];
        $this->tipoBebida = $row['tipoBebida'];
        $this->volume = $row['volume'];
        $this->valor = $row['valor'];
    }

    // Método para criar nova bebida (O cozinheiro inventando um drink novo)
    public function create() {
        $query = 'INSERT INTO ' . $this->tabela . ' SET nomeBebida = :nomeBebida, tipoBebida = :tipoBebida, volume = :volume, valor = :valor';
        
        $stmt = $this->conn->prepare($query);
        
        // Limpar os dados
        $this->nomeBebida = htmlspecialchars(strip_tags($this->nomeBebida));
        $this->tipoBebida = htmlspecialchars(strip_tags($this->tipoBebida));
        $this->volume = htmlspecialchars(strip_tags($this->volume));
        $this->valor = htmlspecialchars(strip_tags($this->valor));
        
        // Vincular os parâmetros
        $stmt->bindParam(':nomeBebida', $this->nomeBebida);
        $stmt->bindParam(':tipoBebida', $this->tipoBebida);
        $stmt->bindParam(':volume', $this->volume);
        $stmt->bindParam(':valor', $this->valor);
        
        if ($stmt->execute()) {
            return true;
        }    
        return false;
    }

    // Método para atualizar a bebida (Corrigindo um erro na receita)
    public function update() {
        $query = 'UPDATE ' . $this->tabela . ' SET nomeBebida = :nomeBebida, tipoBebida = :tipoBebida, volume = :volume, valor = :valor WHERE idBebida = :id';
        
        $stmt = $this->conn->prepare($query);
        
        // Limpar os dados
        $this->nomeBebida = htmlspecialchars(strip_tags($this->nomeBebida));
        $this->tipoBebida = htmlspecialchars(strip_tags($this->tipoBebida));
        $this->volume = htmlspecialchars(strip_tags($this->volume));
        $this->valor = htmlspecialchars(strip_tags($this->valor));
        $this->idBebida = htmlspecialchars(strip_tags($this->idBebida));
        
        // Vincular os parâmetros
        $stmt->bindParam(':nomeBebida', $this->nomeBebida);
        $stmt->bindParam(':tipoBebida', $this->tipoBebida);
        $stmt->bindParam(':volume', $this->volume);
        $stmt->bindParam(':valor', $this->valor);
        $stmt->bindParam(':id', $this->idBebida);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para deletar (Tirando a bebida do cardápio)
    public function delete() {
        $query = 'DELETE FROM ' . $this->tabela . ' WHERE idBebida = :id';
        
        $stmt = $this->conn->prepare($query);
        
        $this->idBebida = htmlspecialchars(strip_tags($this->idBebida));
        $stmt->bindParam(':id', $this->idBebida);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
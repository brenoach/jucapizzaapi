<?php
// api/bebidas/get.php
 
// Headers obrigatórios
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// Incluir arquivos de banco de dados e modelo
include_once '../../config/Database.php';
include_once '../../models/Bebidas.php';
 
// Instanciar o objeto Database e obter a conexão
$database = new Database();
$db = $database->getConnection();
 
// Instanciar o objeto Bebidas
$bebida = new Bebidas($db);

// Pega o ID passado na URL (ex: get.php?id=1)
$bebida->idBebida = isset($_GET['id']) ? $_GET['id'] : null;
 
if ($bebida->idBebida) {
    // Busca a bebida (Corrigido para read_single)
    $bebida->read_single();
 
    // Cria o array de resposta (Corrigido para verificar nomeBebida)
    if (isset($bebida->nomeBebida) && $bebida->nomeBebida != null) {
        $bebida_arr = array(
            "id" => $bebida->idBebida,
            "nome" => $bebida->nomeBebida,
            "tipo" => $bebida->tipoBebida,
            "volume" => $bebida->volume,
            "valor" => $bebida->valor
        );
 
        http_response_code(200);
        echo json_encode($bebida_arr, JSON_PRETTY_PRINT);
    } else {
        http_response_code(404);
        // Corrigido o fechamento do array() antes do JSON_PRETTY_PRINT
        echo json_encode(array("Mensagem" => "Nenhuma bebida foi encontrada com este id."), JSON_PRETTY_PRINT);
    }
} else {
    http_response_code(400);
    // Corrigido o fechamento do array() antes do JSON_PRETTY_PRINT
    echo json_encode(array("Mensagem" => "ID da bebida não fornecido."), JSON_PRETTY_PRINT);
}
?>
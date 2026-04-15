<?php
// api/bebida/get.php
 
// Headers obrigatórios
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// Incluir arquivos de banco de dados e modelo
include_once '../../config/Database.php';
include_once '../../models/Bebidas.php';
 
// Instanciar o objeto Database e obter a conexão
$database = new Database();
$db = $database->getConnection();
 
// Instanciar o objeto Pizza
$bebida = new Bebidas($db);

$bebida->idBebida = isset($_GET['id']) ? $_GET['id'] : null;
 
if ($bebida->idBebida) {
    // Busca a pizza
    $bebida->get();
 
    // Cria o array de resposta
    if (isset($bebida->nome)) {
    $pizza_arr = array(
        "id" => $bebida->idBebida,
        "nome" => $bebida->nomeBebida,
        "tipo" => $bebida->tipoBebida,
        "volume" => $bebida->volume,
        "valor" => $bebida->valor
    );
 
    // Converte para JSON e envia a resposta
    // `JSON_PRETTY_PRINT` é opcional, mas deixa o JSON mais legível
    echo json_encode($pizza_arr, JSON_PRETTY_PRINT);
} else {
    http_response_code(404);
    echo json_encode(array("Mensagem" => "Nenhuma bebida foi encontrada con este id.", JSON_PRETTY_PRINT));
}
}else {
        http_response_code(400);
        echo json_encode(array("Mensagem" => "ID da bebida não fornecido."), JSON_PRETTY_PRINT);
}
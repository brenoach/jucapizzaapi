<?php
 // api/pizza/get.php
 
// Headers obrigatórios
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// Incluir arquivos de banco de dados e modelo
include_once '../../config/Database.php';
include_once '../../models/Pizza.php';
 
// Instanciar o objeto Database e obter a conexão
$database = new Database();
$db = $database->getConnection();
 
// Instanciar o objeto Pizza
$pizza = new Pizza($db);
 
$pizza->idPizza = isset($_GET['id']) ? $_GET['id'] : null;
 
if ($pizza->idPizza) {
    // Busca a pizza
    $pizza->read_single();
 
    if (isset($pizza->nome)) {
        $pizza_arr = array(
            "id" => $pizza->idPizza,
            "nome" => $pizza->nome,
            "ingredientes" => $pizza->ingredientes,
            "valor" => $pizza->valor
        );
        http_response_code(200);
        // Converte para JSON e envia a resposta
        // `JSON_PRETTY_PRINT` é opcional, mas deixa o JSON mais legível
        echo json_encode($pizza_arr, JSON_PRETTY_PRINT);
    } else {
        http_response_code(404);
        echo json_encode(array("Mensagem" => "Nenhuma pizza foi encontrada com este id."), JSON_PRETTY_PRINT);
    }
} else {
    http_response_code(400);
    echo json_encode(array("Mensagem" => "Parâmetro não enviado"), JSON_PRETTY_PRINT);
 }
<?php
// api/pizza/read.php
 
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
$bebidas = new Bebidas($db);


// try{ colocar para demonstrar erro com coluna errada mas lá no método read em pizza
    // Chamar o método read() para buscar as pizzas
    $stmt = $bebidas->read();
    $num = $stmt->rowCount();
 
    // Verificar se mais de 0 registros foram encontrados
    if ($num > 0) {
        // Array de pizzas
        $bebida_arr = array();

  // Percorrer o resultado da consulta
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // A função extract transforma $row['nome'] em apenas $nome
    extract($row);

    $bebida_item = array(
        "id" => $idBebida,
        "nome" => $nomeBebida,
        "tipoBebida" => $tipoBebida,
        "volume" => $volume,
        "valor" => $valor
    );

    array_push($bebida_arr, $bebida_item);
}

// Definir o código de resposta como 200 OK
http_response_code(200);

// Mostrar os dados das pizzas em formato JSON
echo json_encode($bebida_arr);
} else {
// Se nenhuma pizza for encontrada, definir o código de resposta como 404 Not Found
http_response_code(404);

// Informar ao usuário que nenhuma pizza foi encontrada
echo json_encode(
    array("message" => "Nenhuma bebida encontrada.")
);
}
// }
// catch (Exception $e) {
//  echo json_encode(array("erro" => $e->getMessage()));
// }            
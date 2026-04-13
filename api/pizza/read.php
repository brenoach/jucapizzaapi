<?php
 
 
// api/pizza/read.php
 
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
 
 
  try{ //colocar para demonstrar erro com coluna errada mas lá no método read em pizza
     // Chamar o método read() para buscar as pizzas
     $stmt = $pizza->read();
     $num = $stmt->rowCount();
 
     // Verificar se mais de 0 registros foram encontrados
     if ($num > 0) {
         // Array de pizzas
         $pizzas_arr = array();
 
         // Percorrer o resultado da consulta
         while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // A função extract transforma $row['nome'] em apenas $nome
             extract($row);
 
             $pizza_item = array(
                 "id" => $idPizza,
                 "nome" => $nome,
                 "ingredientes" => $ingredientes,
                 "valor" => $valor
             );
 
             array_push($pizzas_arr, $pizza_item);
         }
 
         // Definir o código de resposta como 200 OK
         http_response_code(200);
 
         // Mostrar os dados das pizzas em formato JSON
         echo json_encode($pizzas_arr);
     } else {
         // Se nenhuma pizza for encontrada, definir o código de resposta como 404 Not Found
         http_response_code(404);
 
         // Informar ao usuário que nenhuma pizza foi encontrada
         echo json_encode(
             array("message" => "Nenhuma pizza encontrada.")
         );
     }
  }
  catch (Exception $e) {
   echo json_encode(array("erro" => $e->getMessage()));
 }
}
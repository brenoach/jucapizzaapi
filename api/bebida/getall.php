<?php
// api/bebidas/getall.php
 
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
$bebidas = new Bebidas($db);
 
 try{ 
     // Chamar o método read() para buscar as bebidas
     $stmt = $bebidas->read();
     $num = $stmt->rowCount();
 
     // Verificar se mais de 0 registros foram encontrados
     if ($num > 0) {
         // Array de bebidas
         $bebidas_arr = array();
 
         // Percorrer o resultado da consulta
         while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
             // Extrai os dados do array $row para variáveis separadas
             extract($row);
 
             // Ajustado para os nomes corretos vindos da consulta do Model
             $bebidas_item = array(
                 "id" => $idBebida,
                 "nome" => $nomeBebida,
                 "tipo" => $tipoBebida, // Adicionei o tipo que estava faltando
                 "volume" => $volume,
                 "valor" => $valor
             );
 
             array_push($bebidas_arr, $bebidas_item);
         }
 
         http_response_code(200);
         echo json_encode($bebidas_arr);
     } else {
         http_response_code(404);
         echo json_encode(
             array("Mensagem" => "Nenhuma bebida encontrada.")
         );
     }
 }
 catch (Exception $e) {
   http_response_code(500);
   echo json_encode(array("erro" => $e->getMessage()));
 }
?>
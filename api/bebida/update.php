<?php
// Headers (O Segurança da porta "Atualizar Bebida")
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// Importando a conexão e a classe Bebidas
include_once '../../config/Database.php';
include_once '../../models/Bebidas.php';

// Instanciar banco de dados e conectar
$database = new Database();
$db = $database->getConnection();

// Instanciar o objeto Bebidas
$bebida = new Bebidas($db);

// Verifica se o cliente usou a porta certa (PUT)
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    try {
        // Pega os dados enviados pelo cliente
        $data = json_decode(file_get_contents("php://input"));

        // Regra de Ouro: Para atualizar, o ID é obrigatório!
        if (!empty($data->id) && !empty($data->nomeBebida) && !empty($data->tipoBebida) && !empty($data->volume) && !empty($data->valor)) {
            
            // Atribui o ID e os novos dados ao objeto
            $bebida->idBebida = $data->id;
            $bebida->nomeBebida = $data->nomeBebida;
            $bebida->tipoBebida = $data->tipoBebida;
            $bebida->volume = $data->volume;
            $bebida->valor = $data->valor;

            // Tenta salvar as alterações no banco
            if ($bebida->update()) {
                http_response_code(200); // 200 = OK
                echo json_encode(
                    array('Mensagem' => 'Bebida atualizada com sucesso!')
                );
            } else {
                http_response_code(503);
                echo json_encode(
                    array('Mensagem' => 'Não foi possível atualizar a bebida.')
                );
            }
        } else {
            http_response_code(400); 
            echo json_encode(
                array('Mensagem' => 'Dados incompletos. Forneça o ID e todos os campos da bebida.')
            );
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(array("erro" => $e->getMessage()));
    }
} else {
    http_response_code(405);
    echo json_encode(array("erro" => "Método não suportado! Use PUT."));
}
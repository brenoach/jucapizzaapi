<?php

// Headers (O Segurança e o Garçom da porta "Deletar Bebida")
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// Importando a conexão e o "Molde" da Bebida
include_once '../../config/Database.php';
include_once '../../models/Bebida.php';

// Instanciar o banco de dados e conectar
$database = new Database();
$db = $database->getConnection();

// Instanciar o objeto Bebida em vez de Pizza
$bebida = new Bebida($db);

// Verifica se o método usado pelo cliente realmente foi um pedido de cancelamento (DELETE)
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    try {
        // Obter os dados que o cliente enviou no corpo da requisição (geralmente um JSON com o ID)
        $data = json_decode(file_get_contents("php://input"));

        // Verificar se o ID da bebida foi fornecido
        if (!empty($data->id)) {
            
            // Atribuir o ID recebido à propriedade idBebida do nosso objeto
            $bebida->idBebida = $data->id;

            // Tentar deletar a bebida no banco
            if ($bebida->delete()) {
                http_response_code(200); // 200 = OK
                echo json_encode(
                    array('Mensagem' => 'Bebida deletada com sucesso!')
                );
            } else {
                http_response_code(500); // 500 = Erro interno do servidor (problema na cozinha)
                echo json_encode(
                    array('Mensagem' => 'Não foi possível deletar a bebida.')
                );
            }
        } else {
            http_response_code(400); // 400 = Bad Request (Cliente esqueceu de mandar o ID)
            echo json_encode(
                array('Mensagem' => 'ID inválido. Não foi possível deletar a bebida.')
            );
        }

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(array("erro" => $e->getMessage()));
    }
} else {
    http_response_code(405); // 405 = Method Not Allowed (Tentou usar GET ou POST numa rota de DELETE)
    echo json_encode(array("erro" => "Método não suportado!"));
}
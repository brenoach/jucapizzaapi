<?php
// Headers (O Segurança da porta "Nova Bebida")
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

// Importando a conexão e a classe Bebidas
include_once '../../config/Database.php';
include_once '../../models/Bebidas.php';

// Instanciar banco de dados e conectar (Abrir a despensa)
$database = new Database();
$db = $database->getConnection();

// Instanciar o objeto Bebidas
$bebida = new Bebidas($db);

// Verifica se o cliente usou a porta certa (POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Pega o "papelzinho" com o pedido do cliente (o JSON)
        $data = json_decode(file_get_contents("php://input"));

        // Verifica se o cliente preencheu todos os campos obrigatórios
        if (!empty($data->nomeBebida) && !empty($data->tipoBebida) && !empty($data->volume) && !empty($data->valor)) {
            
            // Passa as informações do papelzinho para o nosso objeto
            $bebida->nomeBebida = $data->nomeBebida;
            $bebida->tipoBebida = $data->tipoBebida;
            $bebida->volume = $data->volume;
            $bebida->valor = $data->valor;

            // Manda o cozinheiro criar a bebida no banco
            if ($bebida->create()) {
                http_response_code(201); // 201 = Created (Criado com sucesso)
                echo json_encode(
                    array('Mensagem' => 'Bebida cadastrada com sucesso!')
                );
            } else {
                http_response_code(503); // 503 = Service Unavailable (Deu ruim na cozinha)
                echo json_encode(
                    array('Mensagem' => 'Não foi possível cadastrar a bebida.')
                );
            }
        } else {
            http_response_code(400); // 400 = Bad Request (Faltou informação)
            echo json_encode(
                array('Mensagem' => 'Dados incompletos. Preencha todos os campos.')
            );
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(array("erro" => $e->getMessage()));
    }
} else {
    http_response_code(405); // 405 = Method Not Allowed
    echo json_encode(array("erro" => "Método não suportado! Use POST."));
}
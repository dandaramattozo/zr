<?php
require_once "./config/Database.php";
require_once './models/Client.php';
require_once './models/Contact.php';

class ClientActions {

    public function create() {
        // Inclui a visualização do formulário
        include 'views/create_client.php';
    }

    public function store() {
        // Captura os dados do formulário
        $data = [
            ':cpf' => $_POST['cpf'],
            ':rg' => $_POST['rg'],
            ':name' => $_POST['name'],
            ':nickname' => $_POST['nickname'],
            ':birth' => $_POST['birth'],
            ':gender' => $_POST['gender'],
            ':email' => $_POST['email'],
            ':phone' => $_POST['phone'],
            ':zipcode' => $_POST['zipcode'],
            ':address' => $_POST['address'],
            ':number' => $_POST['number'],
            ':complement' => $_POST['complement'],
            ':reference' => $_POST['reference'],
            ':neighborhood' => $_POST['neighborhood'],
            ':city' => $_POST['city'],
            ':state' => $_POST['state']
        ];

        // Cria o cliente
        $clientModel = new Client();
        $clientModel->create($data);

        // Recupera o ID do cliente inserido
        $clientId = $clientModel->conn->lastInsertId();

        // Adiciona contatos
        foreach ($_POST['email'] as $index => $email) {
            $contactData = [
                ':client_id' => $clientId,
                ':email' => $email,
                ':phone' => $_POST['phone'][$index]
            ];
            $contactModel = new Contact();
            $contactModel->create($contactData);
        }

        // Redireciona ou exibe uma mensagem de sucesso
        header('Location: /clients');
    }


}

<?php
require_once "../config/Database.php"; // Ajuste o caminho conforme necessário
require_once "../models/Client.php";   // Ajuste o caminho conforme necessário

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $database = new Database();
    $db = $database->connect();

    $client = new Client($db);
    $cpf = $_GET['cpf'];

    // Verifica se o CPF já está cadastrado
    if ($client->exists($cpf)) {
        echo json_encode(['exists' => true]);
    } else {
        echo json_encode(['exists' => false]);
    }
}
?>

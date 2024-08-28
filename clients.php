<?php

$pageTitle = "Cadastrar Cliente";

ob_start();
?>

<div class="container mt-5">

    <div class="dropdown mb-3">
        <button class="btn btn-primary dropdown-toggle" type="button" id="optionsButton" data-bs-toggle="dropdown" aria-expanded="false">
            Opções
        </button>
        <ul class="dropdown-menu" aria-labelledby="optionsButton">
            <li><input type="checkbox" class="column-toggle" data-column="1" checked> <label>ID</label></li>
            <li><input type="checkbox" class="column-toggle" data-column="2" checked> <label>Nome</label></li>
            <li><input type="checkbox" class="column-toggle" data-column="3" checked> <label>Birth</label></li>
            <li><input type="checkbox" class="column-toggle" data-column="4" checked> <label>E-mail</label></li>
            <li><input type="checkbox" class="column-toggle" data-column="5" checked> <label>Telefone</label></li>
            <li><input type="checkbox" class="column-toggle" data-column="6" checked> <label>CEP</label></li>
            <li><input type="checkbox" class="column-toggle" data-column="7" checked> <label>Cidade</label></li>
            <li><input type="checkbox" class="column-toggle" data-column="8" checked> <label>Estado</label></li>
        </ul>
    </div>



        <form id="clientsForm" method="post" action="">
        <table class="table" id="clientsTable" class="display">
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectAll"></th> 
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Birth</th>
                    <th>E-mail</th>
                    <th>Telefone</th>
                    <th>CEP</th>
                    <th>Cidade</th>
                    <th>Estado</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once './config/Database.php';
                require_once './models/Client.php';

                $database = new Database();
                $db = $database->connect();

                $client = new Client($db);
                $result = $client->read();

                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td><input type='checkbox' name='selected_clients[]' value='{$row['id']}'></td>"; 
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['name']}</td>";
                    echo "<td>{$row['birth']}</td>";
                    echo "<td>{$row['email']}</td>";
                    echo "<td>{$row['phone']}</td>";
                    echo "<td>{$row['zipcode']}</td>";
                    echo "<td>{$row['city']}</td>";
                    echo "<td>{$row['state']}</td>";
                    echo "<td>
                    <div class='dropdown'>
                        <button class='btn btn-primary btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-bs-toggle='dropdown' aria-expanded='false'>
                            Ação
                        </button>
                        <ul class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                            <li><a class='dropdown-item' href='edit_client.php?id={$row['id']}'>Editar</a></li>
                            <li><a class='dropdown-item' href='delete_client.php?id={$row['id']}'>Excluir</a></li>
                        </ul>
                    </div>
                  </td>";
                    
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>


<?php
$content = ob_get_clean();
include './views/layout.php';
?>

<?php
require_once "./config/Database.php";
require_once "./models/Client.php";

$message = '';
$messageType = '';
$emailError = ''; // Variável para armazenar o erro de e-mail

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $db = $database->connect();

    $client = new Client($db);

    $client->cpf = $_POST['cpf'];
    $client->rg = $_POST['rg'];
    $client->name = $_POST['name'];
    $client->nickname = $_POST['nickname'];
    $client->birth = $_POST['birth'];
    $client->gender = $_POST['gender'];
    $client->zipcode = $_POST['zipcode'];
    $client->state = $_POST['state'];
    $client->city = $_POST['city'];
    $client->neighborhood = $_POST['neighborhood'];
    $client->address = $_POST['address'];
    $client->number = $_POST['number'];
    $client->complement = $_POST['complement'];
    $client->reference = $_POST['reference'];
    $client->phone = $_POST['phone'];
    $client->email = $_POST['email'];


    // Validação de e-mail
    if (!filter_var($client->email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "E-mail inválido."; // Definir erro específico para o campo de e-mail
        $messageType = 'error'; // Definir o tipo de erro global
    } else {
        // Se o e-mail for válido, prosseguir com o cadastro do cliente
        if ($client->create()) {
            $message = "Cliente cadastrado com sucesso!";
            $messageType = 'success'; // Sucesso
        } else {
            $message = "Erro ao cadastrar cliente.";
            $messageType = 'error'; // Erro
        }
    }


}



$pageTitle = "Cadastrar Cliente";

ob_start();
?>

<div class="container my-5">
<h3 class="title">Dados Responsável</h3>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="liveToast" class="toast bg-<?php echo $messageType === 'success' ? 'success' : 'danger'; ?>" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <strong class="me-auto">Notificação</strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      <?php echo $message; ?>
    </div>
  </div>
</div>

<form action="" method="POST">
<div class="row">
    <div class="col-md-3">
        <div class="mb-3">
            <label for="cpf" class="form-label">CPF</label>
            <input type="tel" class="form-control" id="cpf" name="cpf" required>
        </div>
    </div>
    <div class="col-md-3">
        <div class="mb-3">
            <label for="rg" class="form-label">RG</label>
            <input type="tel" class="form-control" id="rg" name="rg" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" class="form-control" id="name" name="name" required>
            <div class="invalid-feedback">
                Por favor, insira o nome e o sobrenome.
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="mb-3">
            <label for="nickname" class="form-label">Apelido</label>
            <input type="text" class="form-control" id="nickname" name="nickname">
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label for="birth" class="form-label">Data de Nascimento</label>
            <input type="date" class="form-control" id="birth" name="birth" required>
            <div class="invalid-feedback">
                A data de nascimento não pode ser futura.
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label for="gender" class="form-label">Gênero</label>
            <select class="form-control" id="gender" name="gender" required>
                <option value="">Selecione</option>
                <option value="male">Masculino</option>
                <option value="female">Feminino</option>
                <option value="other">Outro</option>
            </select>
        </div>
    </div>
</div>

<hr>
<h3 class="title">Contatos</h3>
<div id="contacts-section">
    <div class="row contact-row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control <?php echo $emailError ? 'is-invalid' : ''; ?>" name="email" value="<?php echo htmlspecialchars($client->email ?? '', ENT_QUOTES); ?>" required>
                <div class="invalid-feedback">
                    <?php echo $emailError; ?> <!-- Exibe o erro de e-mail -->
                </div>
            </div>
        </div>


  

        <div class="col-md-6">
            <div class="mb-3">
                <label for="phone" class="form-label">Telefone</label>
                <input type="text" class="form-control" name="phone" required>
            </div>
        </div>
    </div>
</div>
<button type="button" class="btn btn-secondary" id="add-contact">Adicionar Mais Contatos</button>

<hr>
<h3 class="title">Endereço</h3>
<div class="row">
    <div class="col-md-2">
        <div class="mb-3">
            <label for="zipcode" class="form-label">CEP</label>
            <input type="text" class="form-control" id="zipcode" name="zipcode" required>
        </div>
    </div>
    <div class="col-md-8">
        <div class="mb-3">
            <label for="address" class="form-label">Endereço</label>
            <input type="text" class="form-control" id="address" name="address" required>
        </div>
    </div>
    <div class="col-md-2">
        <div class="mb-3">
            <label for="number" class="form-label">Número</label>
            <input type="text" class="form-control" id="number" name="number" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="complement" class="form-label">Complemento</label>
            <input type="text" class="form-control" id="complement" name="complement">
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="reference" class="form-label">Referência</label>
            <input type="text" class="form-control" id="reference" name="reference">
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="neighborhood" class="form-label">Bairro</label>
            <input type="text" class="form-control" id="neighborhood" name="neighborhood" required>
        </div>
    </div>
    <div class="col-md-3">
        <div class="mb-3">
            <label for="city" class="form-label">Cidade</label>
            <input type="text" class="form-control" id="city" name="city" required>
        </div>
    </div>
    <div class="col-md-3">
        <div class="mb-3">
            <label for="state" class="form-label">Estado</label>
            <input type="text" class="form-control" id="state" name="state" required>
        </div>
    </div>
</div>

<button type="submit" class="btn btn-primary">Cadastrar</button>

</form>
</div>
<?php
$content = ob_get_clean();
include './views/layout.php';
?>


<script>
document.getElementById('cpf').addEventListener('input', function() {
    const cpf = this.value;
    if (cpf.length === 14) { // Verifica se o CPF completo foi inserido
        checkCpf(cpf);
    }
});
</script>

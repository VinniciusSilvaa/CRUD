<?php 
session_start();
require 'bd/connection.php';

if (isset($_GET['id'])) {
    $id_usuario = $_GET['id'];

    $sql = "SELECT * FROM users WHERE id_users = :id";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':id', $id_usuario, PDO::PARAM_INT);
    $stmt->execute();

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$usuario) {
        echo "Usuário não encontrado.";
        exit;
    }
} else {
    echo "ID do usuário não fornecido.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/edit.css">
    <title>Editar Usuário</title>
</head>
<body>
<?php include ('header.php'); ?>

<main class="main">
    <div class="container-main-header">
        <h1> Editar Usuário </h1>
        <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('senha');
            const toggleButton = document.getElementById('togglePassword');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleButton.textContent = 'Ocultar';
            } else {
                passwordField.type = 'password';
                toggleButton.textContent = 'Mostrar';
            }
        }
    </script>
        <?php 
            if (isset($_SESSION['mensagem_sucesso_edit'])): ?>
                <p style='color: green;'><?= $_SESSION['mensagem_sucesso_edit'] ?></p>
                <?php unset($_SESSION['mensagem_sucesso_edit']); ?>
            <?php endif; 
        ?>
        <a href="index.php"> Voltar </a>
    </div>
    <div class="container-main">
      <form action="crud/update.php" method="POST">   
        
      <input type="hidden" name="id" value="<?= htmlspecialchars($usuario['id_users']) ?>">
      
        <div class="form">
            <label>Nome</label>
            <input type="text" name="nome" value="<?= htmlspecialchars($usuario['nome_users']) ?>">
        </div>
        <div class="form">
            <label>E-mail</label>
            <input type="text" name="email" value="<?= htmlspecialchars($usuario['email_users']) ?>">
        </div>
        
            <?php 
                // Formatação da data //
                $data_nascimento = $usuario['data_nascimento_users'];
                $date = DateTime::createFromFormat('Y-m-d', $data_nascimento);
                $data_formatada = $date ? $date->format('Y-m-d') : ''; 
            ?>

        <div class="form">
            <label>Data de nascimento</label>
            <input type="date" name="data_nascimento" value="<?= htmlspecialchars($data_formatada) ?>">
        </div>

        <div class="form">
            <label>Senha</label>
            <input type="password" id="senha" name="senha" value="<?= htmlspecialchars($usuario['senha_users']) ?>">
            <img class="olho" src="image/olho-vermelho.png" id="togglePassword" onclick="togglePasswordVisibility()">
        </div>

        <div class="but">
            <button type="submit" name="edit_usuario"> Editar </button>
        </div>
      </form>
    </div>
</main>
</body>
</html>

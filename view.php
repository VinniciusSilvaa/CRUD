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
    <link rel="stylesheet" href="css/view.css">
    <title>Visualizar usuario</title>
</head>
<body>
<?php include ('header.php'); ?>

<main class="main">
    <div class="container-main-header">
        <h1> visualizando usuario </h1>
        <a href="index.php"> Voltar </a>
    </div>
    <div class="container-main">  
        <div class="form">
            <label>Nome</label>
            <input type="text" name="nome" value="<?= htmlspecialchars($usuario['nome_users']) ?>" readonly>
        </div>
        <div class="form">
            <label>E-mail</label>
            <input type="text" name="email" value="<?= htmlspecialchars($usuario['email_users']) ?>" readonly>
        </div>
        <div class="form">
            <label>Data de nascimento </label>
            <input type="date" name="data_nascimento" value="<?= htmlspecialchars($usuario['data_nascimento_users']) ?>" readonly>
        </div>
    </div>
</main>
</body>
</html>
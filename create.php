<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/create.css">
    <title>Criar usuario</title>
</head>
<body>
<?php include ('header.php'); ?>

<main class="main">
    <div class="container-main-header">
        <h1> Adicionar usuários </h1>
        <a href="index.php"> Voltar </a>
    </div>
    <div class="container-main">
      <form action="crud/creat.php" method="POST">    
        <div class="form">
            <label>Nome</label>
            <input type="text" name="nome" required>
        </div>
        <div class="form">
            <label>E-mail</label>
            <input type="text" name="email" required>
            <?php if (isset($_SESSION['erro_email'])): ?>
                <p style='color: red;'><?= $_SESSION['erro_email'] ?></p>
                <?php unset($_SESSION['erro_email']); ?>
            <?php endif; ?>
        </div>
        <div class="form">
            <label>Data de nascimento </label>
            <input type="date" name="data_nascimento" required>
        </div>
        <div class="form">
            <label>Senha</label>
            <input type="password" name="senha" required>
        </div>
        <div class="but">
            <button type="submit" name="create_usuario"> Criar </button>
        </div>
      </form>
    </div>
</main>
</body>
</html>
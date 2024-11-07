<?php 
session_start();
require '../bd/connection.php';

if (isset($_POST['create_usuario'])) {
    $nome = $_POST['nome'];
    $email= $_POST['email'];
    $data_nascimento = $_POST['data_nascimento'];
    $senha = $_POST['senha'];

    try {
        $sql = "SELECT * FROM users WHERE email_users = :email";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Se encontrar um registro, significa que o e-mail já está em uso
        if ($stmt->rowCount() > 0) {
            $_SESSION['erro_email'] = "O e-mail já está em uso. Por favor, escolha outro e-mail.";
            header("location: ../create.php");
            exit();
        }

        $sql = "INSERT INTO users (nome_users, email_users, data_nascimento_users, senha_users) VALUES (:nome, :email, :data_nascimento, :senha)";
        $stmt = $connection->prepare($sql);

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':data_nascimento', $data_nascimento);
        $stmt->bindParam(':senha', $senha); 

        $stmt->execute();

        $_SESSION['mensagem_sucesso'] = "Usuario cadastrado com sucesso!";
        header("location: ../index.php");
        exit();
    }catch (PDOException $e) {
        echo "Erro ao cadastrar usuario: " . $e->getMessage();
    }
}
?>
<?php 
session_start();
require '../bd/connection.php';

if (isset($_POST['edit_usuario'])) {
    $id_usuario = $_POST['id'];
    $nome = $_POST['nome'];
    $email= $_POST['email'];
    $data_nascimento = $_POST['data_nascimento'];
    $senha = $_POST['senha'];

    try {
        $sql = "UPDATE users SET nome_users = :nome, email_users = :email, data_nascimento_users = :data_nascimento, senha_users = :senha WHERE id_users = :id";
        $stmt = $connection->prepare($sql);

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':data_nascimento', $data_nascimento);
        $stmt->bindParam(':senha', $senha); 
        $stmt->bindParam(':id', $id_usuario, PDO::PARAM_INT);

        $stmt->execute();

        $_SESSION['mensagem_sucesso_edit'] = "Usuario editado com sucesso!";
        header("location: ../edit.php?id=" . $id_usuario);
        exit();
    }catch (PDOException $e) {
        echo "Erro ao cadastrar usuario: " . $e->getMessage();
    }
}
?>
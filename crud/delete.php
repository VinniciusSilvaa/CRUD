<?php 
session_start();
require '../bd/connection.php';

if(isset($_POST['id'])){

    $id_usuario = $_POST['id'];

    try {
        $sql = "DELETE FROM USERS WHERE id_users = :id";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':id', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        
        $_SESSION['mensagem_sucesso_delet'] = "Usuário deletado com sucesso!";
        header("location: ../index.php");
        exit();
    } catch (PDOException $e) {
        echo "Erro ao excluir usuário: " . $e->getMessage();
    }
} else 
header ("location: ../index.php");
exit();


?>
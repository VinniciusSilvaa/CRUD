<?php 
session_start();
require 'bd/connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title> CRUD </title>
</head>
<body>
    <?php include ('header.php'); ?>

    <main class="main">
        <div class="container-main-header">
            <h1> Lista de usuários </h1>
            <?php if (isset($_SESSION['mensagem_sucesso'])): ?>
                <p style='color: green;'><?= $_SESSION['mensagem_sucesso'] ?></p>
                <?php unset($_SESSION['mensagem_sucesso']); ?>
            <?php endif; ?>
            <?php if (isset($_SESSION['mensagem_sucesso_delet'])): ?>
                <p style='color: green;'><?= $_SESSION['mensagem_sucesso_delet'] ?></p>
                <?php unset($_SESSION['mensagem_sucesso_delet']); ?>
            <?php endif; ?>
            <a href="create.php"> Adicionar usuários</a>
        </div>
        <div class="container-main">
            <table>
                <thead>
                <tr>
                    <th> ID </th>
                    <th> Nome </th>
                    <th> E-mail</th>
                    <th> Data de Nascimento </th>
                    <th> Ações </th>
                </tr>
                </thead>
                <tbody>
                    <?php 
                    $sql = "SELECT * FROM users";
                    $stmt = $connection->prepare($sql);
                    $stmt->execute();
                    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($usuarios as $usuario): 
                        if (isset($usuario['id_users'], $usuario['nome_users'], $usuario['email_users'], $usuario['data_nascimento_users'])): ?>
                            <tr>
                                <td><?= $usuario['id_users'] ?></td>
                                <td><?= $usuario['nome_users'] ?></td>
                                <td><?= $usuario['email_users'] ?></td>
                                <td><?=date('d/m/Y', strtotime($usuario['data_nascimento_users']))?></td>
                                <td class='actions'> 
                                    <a class='blue' href='view.php?id=<?= $usuario['id_users'] ?>'>Visualizar</a>
                                    <a class='green' href='edit.php?id=<?= $usuario['id_users'] ?>'>Editar</a>
                                    <form id="deleteForm<?= $usuario['id_users'] ?>" action="crud/delete.php" method="POST">
                                        <input type="hidden" name="id" value="<?= $usuario['id_users'] ?>">
                                        <button class="bt" type="button" onclick="showDeleteModal('deleteForm<?= $usuario['id_users'] ?>')">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        <?php else: ?>
                            <tr><td colspan='5'>Erro: Dados do usuário incompletos.</td></tr>
                        <?php endif; 
                    endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Modal de Confirmação -->
    <div id="deleteModal">
            <h3>Você tem certeza que deseja excluir este usuário?</h3>
            <div class="modal-buttons">
                <button class="b-green" onclick="confirmDelete()">Sim</button>
                <button class="b-red" onclick="closeModal()">Não</button>
            </div>
    </div>

    <script>
        let addformId = null;

        // Exibir o modal de confirmação
        function showDeleteModal(formId) {
            addformId = formId;
            document.getElementById('deleteModal').style.display = 'flex';
        }

        // Fechar o modal
        function closeModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }

        // Confirmar exclusão
        function confirmDelete() {
            document.getElementById(addformId).submit();  // Submeter o formulário
            closeModal();  // Fechar o modal
        }
    </script>

</body>
</html>

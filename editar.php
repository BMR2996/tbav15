<?php
require_once 'connection.php';

// Definir as variáveis de conexão
$host = 'localhost';
$db = 'escola';
$user = 'gabriel';
$pass = '123456';
$port = 3307;

// Criar a instância da classe Database e conectar
$database = new Database($host, $db, $user, $pass, $port);
$database->connect();
$pdo = $database->getConnection();

// Verificar se o ID foi passado pela URL
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Verificar se o formulário foi enviado
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nome = htmlspecialchars($_POST['nome']);
        $idade = (int) $_POST['idade'];
        $email = htmlspecialchars($_POST['email']);
        $curso = htmlspecialchars($_POST['curso']);

        if ($pdo) {
            $stmt = $pdo->prepare("UPDATE alunos SET nome = :nome, idade = :idade, email = :email, curso = :curso WHERE id = :id");
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':idade', $idade);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':curso', $curso);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                echo "Dados atualizados com sucesso!";
            } else {
                echo "Erro ao atualizar os dados.";
            }
        }
    } else {
        // Buscar os dados do aluno pelo ID
        $stmt = $pdo->prepare("SELECT * FROM alunos WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $aluno = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($aluno) {
            ?>

            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Editar Aluno</title>
            </head>
            <body>
                <h2>Editar Aluno</h2>
                <form action="editar.php?id=<?= $id ?>" method="POST">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" value="<?= $aluno['nome'] ?>" required><br><br>

                    <label for="idade">Idade:</label>
                    <input type="number" name="idade" value="<?= $aluno['idade'] ?>" required><br><br>

                    <label for="email">Email:</label>
                    <input type="email" name="email" value="<?= $aluno['email'] ?>" required><br><br>

                    <label for="curso">Curso:</label>
                    <input type="text" name="curso" value="<?= $aluno['curso'] ?>" required><br><br>

                    <input type="submit" value="Atualizar">
                </form>
            </body>
            </html>

            <?php
        } else {
            echo "Aluno não encontrado.";
        }
    }
} else {
    echo "ID do aluno não informado.";
}
?>

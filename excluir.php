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

    if ($pdo) {
        // Preparar a exclusão do aluno
        $stmt = $pdo->prepare("DELETE FROM alunos WHERE id = :id");
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            // Redirecionar para index.php com mensagem de sucesso
            header("Location: index.php?status=excluido");
            exit(); // Finaliza o script após o redirecionamento
        } else {
            // Redirecionar para index.php com mensagem de erro
            header("Location: index.php?status=erro_excluir");
            exit();
        }
    } else {
        echo "Erro na conexão com o banco de dados.";
    }
} else {
    echo "ID do aluno não informado.";
}
?>

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = htmlspecialchars($_POST['nome']);
    $idade = (int)$_POST['idade'];
    $email = htmlspecialchars($_POST['email']);
    $curso = htmlspecialchars($_POST['curso']);

    if ($pdo) {
        $stmt = $pdo->prepare("INSERT INTO alunos (nome, idade, email, curso) VALUES (:nome, :idade, :email, :curso)");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':idade', $idade);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':curso', $curso);

        if ($stmt->execute()) {
            // Redirecionar para index.php com a mensagem de sucesso
            header("Location: index.php?status=sucesso");
            exit(); // Finaliza o script após o redirecionamento
        } else {
            // Redirecionar para index.php com a mensagem de erro
            header("Location: index.php?status=erro");
            exit();
        }
    } else {
        echo "Erro na conexão com o banco de dados.";
    }
}
?>

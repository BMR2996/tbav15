<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informação de Aluno</title>
 <link rel="stylesheet" href ="css/estilo.css">
</head>
<body>
    <h2>Informação de Aluno</h2>

    <!-- Formulário de cadastro de aluno -->
    <form action="cadastrar.php" method="POST">
        <input type="text" name="nome" placeholder="Nome do aluno" required><br><br>
        <input type="number" name="idade" placeholder="Idade do aluno" required><br><br>
        <input type="email" name="email" placeholder="Email do aluno" required><br><br>
        <input type="text" name="curso" placeholder="Curso do aluno" required><br><br>
        <input type="submit" value="Cadastrar Aluno" class="botao">
    </form>
    <?php
    // Exibir mensagem de sucesso ou erro, se houver
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'sucesso') {
            echo "<p style='color:green;'>Aluno cadastrado com sucesso!</p>";
        } elseif ($_GET['status'] == 'erro') {
            echo "<p style='color:red;'>Erro ao cadastrar o aluno.</p>";
        } elseif ($_GET['status'] == 'excluido') {
            echo "<p style='color:green;'>Aluno excluído com sucesso!</p>";
        } elseif ($_GET['status'] == 'erro_excluir') {
            echo "<p style='color:red;'>Erro ao excluir o aluno.</p>";
        }
    }
    ?>
    <form action="index.php" method="GET">
        <input type="text" name="pesquisa" placeholder="Pesquisar aluno ou curso">
        <input type="submit" value="Pesquisar" class="botao">
    </form>

    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Idade</th>
                <th>Email</th>
                <th>Curso</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
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

            // Verificar se a conexão foi estabelecida
            if ($pdo) {
                $pesquisar = isset($_GET['pesquisa']) ? htmlspecialchars($_GET['pesquisa']) : '';
                $stmt = $pdo->prepare("SELECT * FROM alunos WHERE nome LIKE :pesquisa OR curso LIKE :pesquisa");
                $stmt->bindValue(':pesquisa', "%$pesquisar%");
                $stmt->execute();
                $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($alunos) {
                    foreach ($alunos as $aluno) {
                        echo "
                        <tr>
                            <td>{$aluno['nome']}</td>
                            <td>{$aluno['idade']}</td>
                            <td>{$aluno['email']}</td>
                            <td>{$aluno['curso']}</td>
                            <td>
                                <a href='editar.php?id={$aluno['id']}'>Editar</a>
                                <a href='excluir.php?id={$aluno['id']}'>Excluir</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Nenhum resultado encontrado.</td></tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Erro na conexão com o banco de dados.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

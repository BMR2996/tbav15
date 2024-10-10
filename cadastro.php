<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Aluno</title>
</head>
<body>
    <form method="GET">
        <input type="text" name="pesquisa" placeholder="Pesquisar aluno">
        <button type="submit">Buscar</button>
    </form>

    <table border="1">
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
            // Definir as variáveis de conexão
            $host = 'localhost';
            $db = 'escola';
            $user = 'gabriel';
            $pass = '123456';
            $port = 3307;

            // Incluir o arquivo de conexão que possui a classe Database
            require_once 'connection.php';

            // Cria uma instância da classe Database
            $database = new Database($host, $db, $user, $pass, $port);

            // Chama o método connect para estabelecer a conexão
            $database->connect();

            // Obtém a instância PDO para realizar consultas
            $pdo = $database->getConnection();

            // Verifica se a conexão foi bem-sucedida antes de realizar qualquer consulta
            if ($pdo) {
                // Exemplo de consulta, adapte conforme sua necessidade
                $pesquisar = isset($_GET['pesquisa']) ? $_GET['pesquisa'] : '';
                $query = "SELECT * FROM escola.alunos WHERE nome LIKE :pesquisa OR curso LIKE :pesquisa";

                // Prepara a consulta SQL
                $stmt = $pdo->prepare($query);
                $pesquisaParam = "%$pesquisar%";
                $stmt->bindParam(':pesquisa', $pesquisaParam);

                // Executa a consulta e captura os resultados
                $stmt->execute();
                $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($resultado) {
                    foreach ($resultado as $row) {
                        echo "
                        <tr>
                            <td>{$row['nome']}</td>
                            <td>{$row['idade']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['curso']}</td>
                            <td>
                                <a href='editar.php?id={$row['id']}'>Editar</a>
                                <a href='excluir.php?id={$row['id']}'>Excluir</a>
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

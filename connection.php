<?php
class Database {
    // Declaração de variáveis privadas que armazenam os parâmetros de conexão com o banco de dados
    private $host;
    private $db;
    private $user;
    private $pass;
    private $port;
    private $pdo; // Variável que armazenará a instância do PDO (conexão com o banco de dados)

    // O construtor da classe recebe os parâmetros de conexão e os atribui às variáveis privadas
    public function __construct($host, $db, $user, $pass, $port) {
        $this->host = $host; // Endereço do servidor
        $this->db = $db;     // Nome do banco de dados
        $this->user = $user; // Usuário do banco de dados
        $this->pass = $pass; // Senha do banco de dados
        $this->port = $port; // Porta do servidor de banco de dados
    }

    // Método que estabelece a conexão com o banco de dados utilizando o PDO
    public function connect() {
        try {
            // Monta a string DSN (Data Source Name) para a conexão com o banco MySQL
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->db}";
            
            // Instancia o objeto PDO com os parâmetros DSN, usuário e senha
            $this->pdo = new PDO($dsn, $this->user, $this->pass);
            
            // Configura o PDO para lançar exceções quando ocorrerem erros
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Caso ocorra algum erro de conexão, exibe a mensagem de erro e define $pdo como null
            echo 'Conexão falhou: ' . $e->getMessage();
            $this->pdo = null;
        }
    }

    // Método que retorna a conexão ativa (ou null se a conexão falhou)
    public function getConnection() {
        return $this->pdo;
    }
}

?>

<?php 

class Database {
    private $pdo;
    private $host;
    private $db;
    private $user;
    private $pass;
    private $port;

    // Define as configurações do banco de dados
    public function __construct($host, $db, $user, $pass, $port = 3307) { 
        $this->host = $host;
        $this->db = $db;
        $this->user = $user;
        $this->pass = $pass;
        $this->port = $port;
    }

    // Conexão com o banco de dados
    public function connect() {
        try {
            // Cria uma instância de PDO para MySQL
            $this->pdo = new PDO("mysql:host={$this->host};port={$this->port};dbname={$this->db};charset=utf8", $this->user, $this->pass);
            // Define o modo de erro do PDO
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            // Mensagem de erro caso a conexão falhe
            echo "Erro na conexão com o banco de dados MySQL: " . $e->getMessage() . "<br>";
            exit; // Para a execução do script caso a conexão falhe
        }
    }

    // Retornar a instância PDO
    public function getConnection() {
        return $this->pdo;
    }
}

// Instanciando a classe Database com suas credenciais
$database = new Database("localhost", "escola", "isabella", "123456"); // Substitua "seu_usuario" e "sua_senha" pelas suas credenciais
$database->connect();
$pdo = $database->getConnection();
?>

<?php
require('./vendor/autoload.php');

Dotenv\Dotenv::createImmutable(__DIR__)->load();

class DatabaseConnector
{
    private $mysqli;
    private $servername;
    private $username;
    private $password;
    private $database;


    public function __construct()
    {
        $this->servername = $_ENV['DB_SERVER'];
        $this->username = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASSWORD'];
        $this->database = $_ENV['DB_NAME'];
    }
    public function openConnection()
    {
        $this->mysqli = new mysqli($this->servername, $this->username, $this->password, $this->database);
        if ($this->mysqli->connect_error) {
            die("Connection failed: " . $this->mysqli->connect_error);
        }

    }

    public function doSelectQuery($query)
    {
        $this->openConnection();
        $result = $this->mysqli->query($query);
        if (!$result) {
            die("Query execution failed: " . $this->mysqli->error);
        }
        // Obtener todos los resultados como un array asociativo
        $array = $result->fetch_all(MYSQLI_ASSOC);
        $this->closeConnection();
        return $array;
    }

    public function query($sql)
    {
        $this->openConnection();

        // Preparar la consulta
        $stmt = $this->mysqli->prepare($sql);

        // Verificar si ocurrió algún error en la preparación
        if (!$stmt) {
            die("Query preparation failed: " . $this->mysqli->error);
        }

        // Ejecutar la consulta
        $result = $stmt->execute();

        // Cerrar el statement
        $stmt->close();

        $this->closeConnection();

        return $result;
    }

    public function closeConnection()
    {
        $this->mysqli->close();
    }
}
?>
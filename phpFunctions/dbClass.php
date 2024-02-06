<?php
class Database
{
    protected $dbhost = 'localhost';
    protected $dbname = 'webshop_1st';
    protected $db_user = 'root';
    protected $dbpw = '';

    protected function connect()
    {
        try {
            $dsn = "mysql:host=" . $this->dbhost . ";dbname=" . $this->dbname;
            $pdo = new PDO($dsn, $this->db_user, $this->dbpw);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            return $pdo;
        } catch (PDOException $e) {
            die("Connection failed" . $e->getMessage());
        }
    }
}

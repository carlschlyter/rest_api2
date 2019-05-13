<?php
// namespace wiesapi;
// use \PDO;
class DB
{
    private $host    = 'localhost';
    // private $port    = 8889;
    private $db      = 'books';
    private $user    = 'root';
    private $pass    = 'Carlphp2019';
    private $charset = 'utf8mb4';
    private $options = [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];
    public $pdo;
    public function __construct()
    {
        $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $this->options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
}
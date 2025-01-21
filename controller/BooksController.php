<?php 

namespace App\Controller;
use PDO;

class BooksController{
    private $db;

    public function __construct(){
        $configfile = file_get_contents("config.json") ;
        $this->config = json_decode($configfile);
        $this->db = new \PDO('mysql:dbname=' . $this->config->db_name . ';host=' . $this->config->db_host . ';charset=utf8mb4', $this->config->db_user, $this->config->db_pass);
    }

    public function getAllBooks(){
        $books = $this->db->prepare("SELECT * FROM `books`");
        $books->execute();

        $result = $books->fetchAll();
        return $result;
    }
}
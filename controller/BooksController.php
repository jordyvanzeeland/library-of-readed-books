<?php 

namespace App\Controller;
use App\Functions;
use PDO;

class BooksController{
    private $db;
    private $config;
    private $configfile;

    public function __construct(){
        $this->db = (new Functions())->DbConnect();
    }

    public function getAllBooks(){
        $books = $this->db->prepare("SELECT * FROM `books`");
        $books->execute();

        $result = $books->fetchAll();
        return $result;
    }
}
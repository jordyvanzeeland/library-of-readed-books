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
        try{
            $books = $this->db->prepare("SELECT * FROM `books`");
            $books->execute();

            $result = $books->fetchAll();
            echo json_encode($result);
        }catch(Exception $e){
            echo "Error: " . $e;
        }
    }

    public function insertBook(string $name, string $author, string $genre, string $readed, int $rating, int $en){
        try{
            $book = $this->db->prepare("INSERT INTO books (name, author, genre, readed, rating, en) VALUES (?, ?, ?, ?, ?, ?)");
            $book->execute([$name, $author, $genre, $readed, $rating, $en]);
            echo json_encode("Boek " . $name . " is toegevoegd");
        }catch(Exception $e){
            echo "Error: " . $e;
        }
    }

    public function updateBook(int $bookid, string $name, string $author, string $genre, string $readed, int $rating, int $en){
        try{
            $book = $this->db->prepare("UPDATE books SET name = ?, author = ?, genre = ?, readed = ?, rating = ?, en = ? WHERE id = ?");
            $book->execute([$name, $author, $genre, $readed, $rating, $en, $bookid]);
            echo json_encode("Boek " . $name . " is gewijzigd");
        }catch(Exception $e){
            echo "Error: " . $e;
        }
    }

    public function deleteBook(int $bookid, string $bookname){
        try{
            $book = $this->db->prepare("DELETE FROM books WHERE id = ?");
            $book->execute([$bookid]);
            echo json_encode("Boek " . $bookname . " is verwijderd");
        }catch(Exception $e){
            echo "Error: " . $e;
        }
    }
}
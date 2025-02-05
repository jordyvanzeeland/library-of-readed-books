<?php

namespace App\Controller;
use App\Controller\AuthController;
use App\Controller\DBQueryController;

use App\Functions;
use PDO;
use PDOException;

class BooksController {
    private $user;
    private $dbQuery;

    /**
     * Get the current user
     * This will be used trough the class
     */

    public function __construct() {
        $this->user = (new AuthController())->getCurrentUser();
        $this->dbQuery = (new DBQueryController());
    }

    /**
     * Check if a user is authenticated 
     * If not, it returns an Unauthorized message
     */

    public function userAuthenticated(){
        if(!$this->user || $this->user && !$this->user['UserID']){
            echo json_encode(["message" => "Unauthorized"]);
        }
    }

    /**
     * Check if a book exists given it's id. 
     * If not it retuns false.
     */

    public function findBookWithId(int $bookid){
        $book = $this->dbQuery->select('books', ["*"], ["id" => $bookid]);

        if (count($book) === 0) {
            echo json_encode(["message" => "Book not found."]);
        }
        
        return json_encode($book);
    }

    /**
     * Retrieve all books
     */

    public function getAllBooks() {
        $this->userAuthenticated();

        try {
            $books = $this->dbQuery->select('books', ["*"]);
            echo json_encode($books);
        } catch (PDOException $e) {
            echo json_encode(["message" => "Error: " . $e]);
        }
    }

    /**
    * Create a new book
    */

    public function insertBook(string $name, string $author, string $genre, string $readed, int $rating, int $en) {
        $this->userAuthenticated();

        try {
            $book = $this->dbQuery->insert('books', ["name" => $name, "author" => $author, "genre" => $genre, "readed" => $readed, "rating" => $rating, "en" => $en]);
            echo json_encode(["message" => "Boek " . $name . " is toegevoegd"]);
        } catch (PDOException $e) {
            echo json_encode(["message" => "Error: " . $e]);
        }
    }

    /**
    * Update an existing book by it's id.
    * If a book is not found, then it wil give a not found message
    */

    public function updateBook(int $bookId, string $name, string $author, string $genre, string $readed, int $rating, int $en) {
        $this->userAuthenticated();
        
        try {
            $book = $this->findBookWithId($bookId);

            if($book['data']){
                $book = $this->dbQuery->update('books', ["name" => $name, "author" => $author, "genre" => $genre, "readed" => $readed, "rating" => $rating, "en" => $en], ["id" => $bookId]);
                echo json_encode(["success" => true, "message" => "Book '$name' has been updated."]);
            }
        } catch (PDOException $e) {
            echo json_encode(["message" => "Error: " . $e]);
        }
    }

    /**
    * Delete an existing book by it's id.
    * If a book is not found, then it wil give a not found message
    */

    public function deleteBook(int $bookId, string $bookName) {
        $this->userAuthenticated();
        
        try {
            $book = $this->findBookWithId($bookId);
            $book = json_decode($book);
            
            if($book[0]->id){
                $book = $this->dbQuery->delete('books', ["id" => $bookId]);
                echo json_encode(["message" => "Book with ID $bookName has been deleted."]);
            }
        } catch (PDOException $e) {
            echo json_encode(["message" => "Error: " . $e]);
        }
    }
}

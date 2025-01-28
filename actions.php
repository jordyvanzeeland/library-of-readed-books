<?php
namespace App;
require "./vendor/autoload.php"; 
use App\Controller\BooksController;

class JSActionsController{
    private $data;
    private $action;
    private $bookscontroller;

    public function __construct(){
        $this->data = json_decode(file_get_contents('php://input'), true);
        $this->action = $this->data['action'];
        $this->bookscontroller = new BooksController();
    }

    private function insertBook(){
        $this->bookscontroller->insertBook(
            $this->data['book'], 
            $this->data['author'], 
            $this->data['genre'], 
            $this->data['readed'], 
            $this->data['rating'], 
            $this->data['en']
        );
    }

    private function deleteBook(){
        $this->bookscontroller->deleteBook(
            $this->data['bookid'], 
            $this->data['book']
        );
    }

    private function getBooks(){
        return $this->bookscontroller->getAllBooks();
    }

    public function handleRequest(){
        switch ($this->action) {
            case 'add':
                $this->insertBook();
                break;
            case 'delete':
                $this->deleteBook();
                break;
            default:
                $this->getBooks();
                break;
        }
    }
}

(new JSActionsController())->handleRequest();

?>
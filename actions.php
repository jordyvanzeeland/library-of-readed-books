<?php
namespace App;
require "./vendor/autoload.php"; 
use App\Controller\BooksController;

error_reporting(E_ALL);
ini_set('display_errors', 1);

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

    private function getBooksofYear($year){
        return $this->bookscontroller->getBooksByYear($year);
    }
    private function getReadingYears(){
        return $this->bookscontroller->getReadingYears();
    }

    public function handleRequest(){
        $year = !empty($this->data['year']) ? $this->data['year'] : '';

        switch ($this->action) {
            case 'add':
                $this->insertBook();
                break;
            case 'delete':
                $this->deleteBook();
                break;
            case 'getYears':
                $this->getReadingYears();
                break;
            default:
                if($year){
                    $this->getBooksofYear($year);
                }else{
                    $this->getBooks();
                }
                
                break;
        }
    }
}

(new JSActionsController())->handleRequest();

?>
<?php
namespace App;
require "./vendor/autoload.php"; 
use App\Controller\BooksController;

$data = json_decode(file_get_contents('php://input'), true);
$action = $data['action'];

if($action === 'add'){
    (new BooksController())->insertBook($data['book'], $data['author'], $data['genre'], $data['readed'], $data['rating'], $data['en']);
}else if($action === 'delete'){
    (new BooksController())->deleteBook($data['bookid'], $data['book']);
}

?>
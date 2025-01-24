<?php 
    use App\Controller\BooksController;
    $booksList = (new BooksController())->getAllBooks();

    $booksTable = '';

    foreach($booksList as $book){
        $booksTable .= "
        <tr>
            <td>" . $book['name'] . "</td>
            <td>" . $book['author'] . "</td>
            <td>" . $book['genre'] . "</td>
            <td>" . $book['readed'] . "</td>
            <td>" . $book['rating'] . "</td>
        </tr>";
    }
?>

<h1>Library Of Readed Books</h1>
<button onclick="location.href='?logout=1'" name="logout" id="logout">Uitloggen</button>

<table>
    <thead>
        <tr>
            <th>Boek</th>
            <th>Schrijver</th>
            <th>Genre</th>
            <th>Gelezen</th>
            <th>Rating</th>
        </tr>
    </thead>
    <tbody>
        <?php echo $booksTable ?>
    </tbody>
</table>
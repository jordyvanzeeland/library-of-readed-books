<script type="module">
    import Books from "./views/assets/js/Books.js";

    const books = Books();
    books.getBooks()

    document.getElementById('addbook').addEventListener('submit', (event) => {
        event.preventDefault();
        books.addBook(event.target.book.value,event.target.author.value,event.target.genre.value,event.target.readed.value,event.target.rating.value,event.target.en.value);
        event.target.reset();
    })

    document.querySelector('.table-content').addEventListener('click', function(event) {
        if (event.target.classList.contains('delete-book')) {
            const clickedId = event.target.dataset.id;
            const clickedName = event.target.dataset.name;
            books.deleteBook(clickedId, clickedName);
        }
    });
</script>


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
    <tbody class="table-content">
    </tbody>
</table>

<form method="POST" id="addbook">
    <input type="text" name="book" placeholder="Boeknaam" required/>
    <input type="text" name="author" placeholder="Auteur" required/>
    <input type="text" name="genre" placeholder="Genre" required/>
    <input type="text" name="readed" placeholder="Gelezen op" required/>
    <input type="text" name="rating" placeholder="Aantal sterren" required/>
    <input type="text" name="en" placeholder="Engels" required/>
    <input type="submit" value="Toevoegen" />
</form>
<div id="message"></div>
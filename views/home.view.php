<script type="text/javascript">
    const addBook = async (event) => {
        event.preventDefault();

        fetch('/library-of-readed-books/actions.php', {
            method: "POST",
            headers: {
                'Accept': 'application/json',
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                action: 'add',
                book: event.target.book.value,
                author: event.target.author.value,
                genre: event.target.genre.value,
                readed: event.target.readed.value,
                rating: event.target.rating.value,
                en: event.target.en.value
            })
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('message').innerHTML = data;
            getBooks();
        });
    }

    const deleteBook = async (event) => {
        event.preventDefault();
        let data = event.target.parentNode.parentNode.dataset;

        fetch('/library-of-readed-books/actions.php', {
            method: "POST",
            headers: {
                'Accept': 'application/json',
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                action: 'delete',
                bookid: data.id,
                book: data.name
            })
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('message').innerHTML = data;
            getBooks();
        });
    }

    const getBooks = async () => {
        fetch('/library-of-readed-books/actions.php', {
            method: "POST",
            headers: {
                'Accept': 'application/json',
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                action: 'get'
            })
        })
        .then(response => response.json())
        .then(data => {
            const tableContent = document.getElementsByClassName('table-content')[0];
            tableContent.innerHTML = '';
            data.forEach(row => {
                tableContent.innerHTML += `
                <tr data-id=${row.id} data-name=${row.name}>
                    <td>${row.name}</td>
                    <td>${row.author}</td>
                    <td>${row.genre}</td>
                    <td>${row.readed}</td>
                    <td>${row.rating}</td>
                    <td>${row.en}</td>
                    <td><button onclick='deleteBook(event)'>Verwijderen</button></td>
                </tr>`;
            })
        });
    }

    getBooks();
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

<form method="POST" onsubmit="addBook(event)">
    <input type="text" name="book" placeholder="Boeknaam" required/>
    <input type="text" name="author" placeholder="Auteur" required/>
    <input type="text" name="genre" placeholder="Genre" required/>
    <input type="text" name="readed" placeholder="Gelezen op" required/>
    <input type="text" name="rating" placeholder="Aantal sterren" required/>
    <input type="text" name="en" placeholder="Engels" required/>
    <input type="submit" value="Toevoegen" />
</form>
<div id="message"></div>
const Books = () => {

    const addBook = (name, author, genre, readed, rating, en) => {
        fetch('/library-of-readed-books/actions.php', {
            method: "POST",
            headers: {
                'Accept': 'application/json',
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                action: 'add',
                book: name,
                author: author,
                genre: genre,
                readed: readed,
                rating: rating,
                en: en
            })
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('message').innerHTML = data;
            getBooks();
        });
    }
    
    const deleteBook = (bookid, bookname) => {
        event.preventDefault();
    
        fetch('/library-of-readed-books/actions.php', {
            method: "POST",
            headers: {
                'Accept': 'application/json',
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                action: 'delete',
                bookid: bookid,
                book: bookname
            })
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('message').innerHTML = data;
            getBooks();
        });
    }
    
    const getBooks = () => {
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
                    <td><button data-id="${row.id}" data-name=${row.name} class="delete-book">Verwijderen</button></td>
                </tr>`;
            })
        });
    }
    
    return { 
        addBook,
        deleteBook,
        getBooks
     }

}

export default Books;


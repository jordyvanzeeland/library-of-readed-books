import { fetchAction } from "../Functions.js";

const BooksList = () => {
    const addBook = async (name, author, genre, readed, rating, en) => {
        const data = await fetchAction({ action: 'add', book: name, author: author, genre: genre, readed: readed, rating: rating, en: en });
        document.getElementById('message').innerHTML = data;
        getBooks();
    }
    
    const deleteBook = async (bookid, bookname) => {
        const data = await fetchAction({ action: 'delete', bookid: bookid, book: bookname });
        document.getElementById('message').innerHTML = data;
        getBooks();
    }
    
    const getBooks = async () => {
        const data = await fetchAction({ action: 'get' });
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
    }

    const render = () => {
        getBooks();

        document.getElementById('addbook').addEventListener('submit', (event) => {
            event.preventDefault();
            addBook(event.target.book.value,event.target.author.value,event.target.genre.value,event.target.readed.value,event.target.rating.value,event.target.en.value);
            event.target.reset();
        })
    
        document.querySelector('.table-content').addEventListener('click', function(event) {
            if (event.target.classList.contains('delete-book')) {
                const clickedId = event.target.dataset.id;
                const clickedName = event.target.dataset.name;
                deleteBook(clickedId, clickedName);
            }
        });
    }
    
    return { render }
}

export default BooksList;
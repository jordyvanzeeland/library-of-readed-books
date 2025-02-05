import { fetchAction } from "../Functions.js";

const BooksList = () => {
    const addBook = async (name, author, genre, readed, rating, en) => {
        try{
            const data = await fetchAction({ 
                action: 'add', 
                book: name, 
                author: author, 
                genre: genre, 
                readed: readed, 
                rating: rating, 
                en: en 
            });
            document.getElementById('message').textContent = data.message;
            getBooks();
        }catch(error){
            document.getElementById('message').textContent = "An error appeared";
            console.error("Error adding book:", error);
        }
    }
    
    const deleteBook = async (bookid, bookname) => {
        try{
            const data = await fetchAction({ 
                action: 'delete', 
                bookid: bookid, 
                book: bookname 
            });
            document.getElementById('message').textContent = data.message;
            getBooks();
        }catch(error){
            document.getElementById('message').textContent = "An error appeared";
            console.error("Error deleting book:", error);
        }
    }
    
    const getBooks = async () => {
        try{    
            const data = await fetchAction({ 
                action: 'get' 
            });
            const tableContent = document.getElementsByClassName('table-content')[0];
            tableContent.innerHTML = data.map(({ id, name, author, genre, readed, rating, en }) => 
                `<tr data-id=${id} data-name=${name}>
                    <td>${name}</td>
                    <td>${author}</td>
                    <td>${genre}</td>
                    <td>${readed}</td>
                    <td>${rating}</td>
                    <td>${en}</td>
                    <td><button data-id="${id}" data-name=${name} class="delete-book">Verwijderen</button></td>
                </tr>`
            ).join("");
        }catch(error){
            document.getElementById('message').textContent = "An error appeared";
            console.error("Error getting books:", error);
        }
    }

    const render = () => {
        getBooks();

        document.getElementById('addbook').addEventListener('submit', (event) => {
            event.preventDefault();
            addBook(
                event.target.book.value, 
                event.target.author.value, 
                event.target.genre.value, 
                event.target.readed.value, 
                event.target.rating.value, 
                event.target.en.value
            );
            event.target.reset();
        })
    
        document.querySelector('.table-content').addEventListener('click', function(event) {
            if (event.target.classList.contains('delete-book')) {
                const clickedId = event.target.dataset.id;
                const clickedName = event.target.dataset.name;
                deleteBook(
                    clickedId, 
                    clickedName
                );
            }
        });
    }
    
    return { render }
}

export default BooksList;
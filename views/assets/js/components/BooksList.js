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
            document.getElementById('message').innerHTML = "<div class='alert alert-success'>" + data.message + "</div>";
            getBooks();
        }catch(error){
            document.getElementById('message').innerHTML = "<div class='alert alert-danger'>An error appeared</div>";
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
            document.getElementById('message').innerHTML = "<div class='alert alert-success'>" + data.message + "</div>";
            getBooks();
        }catch(error){
            document.getElementById('message').innerHTML = "<div class='alert alert-danger'>An error appeared</div>";
            console.error("Error deleting book:", error);
        }
    }

    const bookRating = (rating) => {
        let stars = '';
        for(let i = 0; i < rating; i++){
            stars += '<i class="fa-solid fa-star"></i>';
        }

        return stars;
    }
    
    const getBooks = async () => {
        try{    
            let table = new DataTable('#DataTable');
                table.destroy();

            const data = await fetchAction({ 
                action: 'get'
            });
            const tableContent = document.getElementsByClassName('table-content')[0];
            tableContent.innerHTML = data.map(({ id, name, author, genre, readed, rating, en }) => 
                `<tr data-id=${id} data-name=${name}>
                    <td>${name}</td>
                    <td>${author}</td>
                    <td><div class="catColor" style="background: ${genre === 'Thriller' ? "rgb(62,69,113)" : (genre === "Roman" ? "rgb(16, 115, 95)" : (genre === "Non-fictie" ? "rgb(220,116,105)" : "rgb(146,48,67)"))}">${genre}</div></td>
                    <td>${new Date(readed).toLocaleString('default', { month: 'long' }) + " " + new Date(readed).getFullYear()}</td>
                    <td class="rating">${bookRating(rating)}</td>
                    <td><button data-id="${id}" data-name=${name} class="delete-book"><i class="fa-solid fa-trash-can"></i></button></td>
                </tr>`
            ).join("");

            setTimeout(() => {
                table = new DataTable('#DataTable', {
                    dom: "rtp",
                    order: [],
                    responsive: true,
                    autoWidth: false
                });
            }, 500)

        }catch(error){
            document.getElementById('message').innerHTML = "<div class='alert alert-danger'>An error appeared</div>";
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
            document.querySelector('.modal').style.display = 'none';
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

        document.querySelector('.add-book').addEventListener('click', function(event) {
            document.querySelector('.modal').style.display = 'block';
        });

        document.querySelector('.btn-close').addEventListener('click', function(event) {
            document.querySelector('.modal').style.display = 'none';
        });
    }
    
    return { render }
}

export default BooksList;
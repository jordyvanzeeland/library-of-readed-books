import { fetchAction } from "../Functions.js";

const BooksList = () => {
    const getReadingYears = async() => {
        try{
            const data = await fetchAction({ 
                action: 'getYears', 
            });

            const readingyears = document.querySelector('.readingyears');
            if(readingyears){
                readingyears.innerHTML = data.map(({ year, count}) => 
                    `<li data-id="${year}" class="yearbtn ${year == localStorage.getItem('year') ? "current" : ''}">${year}</li>`
                ).join("");
            }
    
            return data;
        }catch(error){
            const message = document.getElementById('message');

            if(message){
                document.getElementById('message').innerHTML = "<div class='alert alert-danger'>An error appeared</div>";
                console.error("Error adding book:", error);
            }
        }
    }

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
            const message = document.getElementById('message');

            if(message){
                document.getElementById('message').innerHTML = "<div class='alert alert-danger'>An error appeared</div>";
                console.error("Error adding book:", error);
            }
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
            const message = document.getElementById('message');

            if(message){
                document.getElementById('message').innerHTML = "<div class='alert alert-danger'>An error appeared</div>";
                console.error("Error adding book:", error);
            }
        }
    }

    const bookRating = (rating) => {
        let stars = '';
        for(let i = 0; i < rating; i++){
            stars += '<i class="fa-solid fa-star"></i>';
        }

        return stars;
    }
    
    const getBooks = async (year) => {
        try{    
            const data = await fetchAction({ 
                action: 'get',
                year: year ? year : new Date().getFullYear()
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
        }catch(error){
            const message = document.getElementById('message');

            if(message){
                document.getElementById('message').innerHTML = "<div class='alert alert-danger'>An error appeared</div>";
                console.error("Error adding book:", error);
            }
        }
    }

    const render = () => {
        getReadingYears();
        
        if(!localStorage.getItem('year')){
            localStorage.setItem('year', new Date().getFullYear());
        }

        getBooks(localStorage.getItem('year') ? localStorage.getItem('year') : '');
        const addForm = document.getElementById('addbook');
        
        if(addForm){
            addForm.addEventListener('submit', (event) => {
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
        }

        const table = document.querySelector('.table-content');
    
        if(table){
            table.addEventListener('click', function(event) {
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

        const btnAddBook = document.querySelector('.add-book');
        const btnClose = document.querySelector('.btn-close');
        const readingyears = document.querySelector('.readingyears');
        

        if(btnAddBook){
            btnAddBook.addEventListener('click', function(event) {
                document.querySelector('.modal').style.display = 'block';
            });
        }

        if(btnClose){
            btnClose.addEventListener('click', function(event) {
                document.querySelector('.modal').style.display = 'none';
            });
        }

        if(readingyears){
            readingyears.addEventListener('click', function(event) {
                if (event.target.classList.contains('yearbtn')) {
                    
                    for (var item of event.target.parentNode.children) {
                        item.classList.remove('current');
                    }
                    
                    event.target.classList.add('current')
                    
                    const clickedyear = event.target.dataset.id;
                    localStorage.setItem('year', clickedyear);
                    getBooks(clickedyear);
                }
            });
        }
    }
    
    return { render }
}

export default BooksList;
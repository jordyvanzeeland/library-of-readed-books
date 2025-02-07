<?php require('includes/header.php'); ?>

<div class="container">
<div class="bookslist">
    <h3>Gelezen boeken</h3>
    <table id="DataTable" width="100%">
        <thead>
            <tr>
                <th>Boek</th>
                <th>Schrijver</th>
                <th>Genre</th>
                <th>Gelezen</th>
                <th>Rating</th>
                <th></th>
            </tr>
        </thead>
        <tbody class="table-content">
        </tbody>
    </table>
</div>
</div>

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

<?php require('includes/footer.php'); ?>
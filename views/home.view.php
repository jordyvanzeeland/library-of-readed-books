<?php require('includes/header.php'); ?>

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

<?php require('includes/footer.php'); ?>
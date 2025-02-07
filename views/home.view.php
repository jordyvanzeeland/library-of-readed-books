<?php require('includes/header.php'); ?>

<div class="container">
<div id="message"></div>
<div class="bookslist">
    <button class="btn btn-green add-book"><i class="fa-solid fa-plus"></i> Toevoegen</button>
    <h3>Gelezen boeken</h3>
    <table id="DataTable" class="display" width="100%">
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

<div class="modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Boek toevoegen</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" id="addbook">
            <div class="mb-3">
                <label for="book" class="form-label">Boek</label>
                <input type="text" class="form-control" name="book" id="book" required/>
            </div>
            <div class="mb-3">
                <label for="author" class="form-label">Schrijver</label>
                <input type="text" class="form-control" name="author" id="author" required/>
            </div>
            <div class="mb-3">
                <label for="genre" class="form-label">genre</label>
                <input type="text" class="form-control" name="genre" id="genre" required/>
            </div>
            <div class="mb-3">
                <label for="readed" class="form-label">Gelezen op</label>
                <input type="text" class="form-control" name="readed" id="readed" required/>
            </div>
            <div class="mb-3">
                <label for="rating" class="form-label">Aantal sterren</label>
                <input type="text" class="form-control" name="rating" id="rating" required/>
            </div>
            <div class="mb-3">
                <label for="en" class="form-label">Engels</label>
                <input type="text" class="form-control" name="en" id="en" required/>
            </div>
            <button type="submit" class="btn btn-green">Toevoegen</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php require('includes/footer.php'); ?>
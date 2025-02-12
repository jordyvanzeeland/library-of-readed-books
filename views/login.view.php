<?php require('includes/header.php'); ?>

<?php

use App\Controller\AuthController;

if(isset($_POST['submitlogin'])){
    $delightauth = (new AuthController())->login($_POST['loginmail'], $_POST['loginpass']);
}

?>
<div class="container">
    <div class="login">
        <a class="navbar-brand" href="#" style="margin-bottom:30px;display:block;"><div class="icon">L</div>Library of Readed Books</a>
        <form method="POST">
        <div class="form-group" style="margin-bottom: 20px;">
            <label class="form-check-label" for="loginmail">E-mailadres</label>    
            <input type="text" class="form-control" name="loginmail" id="loginmail" aria-describedby="emailHelp">
        </div>
        <div class="form-group" style="margin-bottom: 20px;">
        <label class="form-check-label" for="loginpass">Wachtwoord</label>    
            <input type="text" class="form-control" name="loginpass" id="loginpass">
        </div>
        <button type="submit" name="submitlogin" id="submitlogin"  class="btn btn-green">Inloggen</button>
        </form>
    </div>
</div>

<?php require('includes/footer.php'); ?>
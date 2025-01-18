<?php
use App\Controller\AuthController;

if(isset($_POST['submitregister'])){
    $delightauth = (new AuthController())->register($_POST['regmail'], $_POST['regpass'], $_POST['reguser']);
}

?>

<h3>register</h3>
<form method="POST">
    <input type="text" name="regmail" id="regmail" placeholder="E-mailadres" />
    <input type="text" name="reguser" id="reguser" placeholder="Gebruikersnaam" />
    <input type="password" name="regpass" id="regpass" placeholder="Wachtwoord" />
    <input type="submit" name="submitregister" id="submitregister" value="register" />
</form>
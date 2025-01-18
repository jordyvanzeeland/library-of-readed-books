<?php

use App\Controller\AuthController;

if(isset($_POST['submitlogin'])){
    $delightauth = (new AuthController())->login($_POST['loginmail'], $_POST['loginpass']);
}

?>

<h3>Inloggen</h3>
<form method="POST">
    <input type="text" name="loginmail" id="loginmail" placeholder="E-mailadres" />
    <input type="password" name="loginpass" id="loginpass" placeholder="Wachtwoord" />
    <input type="submit" name="submitlogin" id="submitlogin" value="Inloggen" />
</form>
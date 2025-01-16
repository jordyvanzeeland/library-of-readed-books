<?php 
namespace App;
require "./vendor/autoload.php"; 
use App\Controller\AuthController;

error_reporting(E_ALL);
ini_set('display_errors', 1);
$currentUser = (new AuthController())->getCurrentUser();

if(isset($_POST['submitlogin'])){
    $delightauth = (new AuthController())->login($_POST['loginmail'], $_POST['loginpass']);
}

if(isset($_POST['submitregister'])){
    $delightauth = (new AuthController())->register($_POST['regmail'], $_POST['regpass'], $_POST['reguser']);
}

if(isset($_GET['logout'])) {
    $delightauth = (new AuthController())->logout();
}
?>

<h1>Library Of Readed Books</h1>

<button name="logout" id="logout">Uitloggen</button>

<h3>Inloggen</h3>
<form method="POST">
    <input type="text" name="loginmail" id="loginmail" placeholder="E-mailadres" />
    <input type="password" name="loginpass" id="loginpass" placeholder="Wachtwoord" />
    <input type="submit" name="submitlogin" id="submitlogin" value="Inloggen" />
</form>

<h3>register</h3>
<form method="POST">
    <input type="text" name="regmail" id="regmail" placeholder="E-mailadres" />
    <input type="text" name="reguser" id="reguser" placeholder="Gebruikersnaam" />
    <input type="password" name="regpass" id="regpass" placeholder="Wachtwoord" />
    <input type="submit" name="submitregister" id="submitregister" value="register" />
</form>
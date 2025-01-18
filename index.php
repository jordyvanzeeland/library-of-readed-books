<?php 
    namespace App;
    require "./vendor/autoload.php"; 
    require "./functions.php";
    use App\Controller\AuthController;

    $pagecontroller = (new Functions())->pageController();
    $debug = (new Functions())->debug(true);

    if(isset($_GET['logout'])) {
        $delightauth = (new AuthController())->logout();
    }
?>
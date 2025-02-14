<?php 
    namespace App;
    require "./vendor/autoload.php"; 
    
    use App\Functions;
    use App\Controller\AuthController;
    use App\Controller\PageController;

    $debug = (new Functions())->debug(true);
    $pagecontroller = (new PageController())->getView(explode('/', $_SERVER['REQUEST_URI'])[1]);

    if(isset($_GET['logout'])) {
        $delightauth = (new AuthController())->logout();
    }
?>
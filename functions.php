<?php

    namespace App;
    use App\Controller\AuthController;

    class Functions{
        public function pageController(){
            $currentUser = (new AuthController())->getCurrentUser();

            if(!$currentUser || $currentUser && !$currentUser['UserID']){
                require_once(__DIR__ . "/views/" . 'login.view.php');
            }else{
                $urlslices = explode('/', $_SERVER['REQUEST_URI']);
                
                if(!isset($urlslices[2]) || isset($urlslices[2]) && $urlslices[2] == ""){
                    require_once(__DIR__ . "/views/" . 'home.view.php');
                }else if(isset($urlslices[2]) && $urlslices[2] !== '' && $urlslices[2] !== '?logout=1'){
                    require_once(__DIR__ . "/views/" . $urlslices[2] . '.view.php');
                }
            }
        }

        public function debug(bool $switch){
            if($switch == true){
                error_reporting(E_ALL);
                ini_set('display_errors', 1);
            }
        }
    }

?>
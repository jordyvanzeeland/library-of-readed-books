<?php
    namespace App\Controller;
    use App\Controller\AuthController;
    
    class PageController{
        public $currentUser;

        public function __construct(){
            $this->currentUser = (new AuthController())->getCurrentUser();
        }

        public function getView(string $view){
            var_dump($this->currentUser);
            if(!$this->currentUser || $this->currentUser && !$this->currentUser['UserID']){
                require_once(dirname(__DIR__, 1) . "/views/" . 'login.view.php');
            }else{
                if(isset($view) && $view !== '' && $view !== '?logout=1'){
                    require_once(dirname(__DIR__, 1) . "/views/" . $view . '.view.php');
                }else if(!isset($view) || isset($view) && $view == ""){
                    require_once(dirname(__DIR__, 1) . "/views/" . 'home.view.php');
                }
            }
        }
    }
?>
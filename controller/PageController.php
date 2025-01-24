<?php
    namespace App\Controller;
    use App\Controller\AuthController;
    
    class PageController{
        public $currentUser;

        public function __construct(){
            $this->currentUser = (new AuthController())->getCurrentUser();
        }

        public function renderTemplate(string $tmpname, array $args = []){
            extract($args, EXTR_SKIP);
            require(dirname(__DIR__, 1) . "/views/" . "{$tmpname}.view.php");
        }

        public function getView(string $view, array $args = []){
            if(!$this->currentUser || $this->currentUser && !$this->currentUser['UserID']){
                $this->renderTemplate('login', $args);
            }else{
                if(isset($view) && $view !== '' && $view !== '?logout=1'){
                    $this->renderTemplate($view, $args);
                }else if(!isset($view) || isset($view) && $view == ""){
                    $this->renderTemplate('home', $args);
                }
            }
        }
    }
?>
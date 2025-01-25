<?php
    namespace App\Controller;
    use App\Controller\AuthController;
    
    class PageController{
        public $currentUser;
        public $viewsfolder;

        public function __construct(){
            $this->currentUser = (new AuthController())->getCurrentUser();
            $this->viewsfolder = dirname(__DIR__, 1) . "/views/";
        }

        public function renderTemplate(string $tmpname, array $args = []){
            extract($args, EXTR_SKIP);
            require($this->viewsfolder . "{$tmpname}.view.php");
        }

        public function getView(string $view, array $args = []){
            if(!$this->currentUser || $this->currentUser && !$this->currentUser['UserID']){
                $this->renderTemplate('login', $args);
            }else{
                if(isset($view) && $view !== '' && $view !== '?logout=1'){
                    if(!file_exists($this->viewsfolder . "{$view}.view.php")){
                        $this->renderTemplate('notfound', $args);
                    }else{
                        $this->renderTemplate($view, $args);
                    }
                }else if(!isset($view) || isset($view) && $view == ""){
                    $this->renderTemplate('home', $args);
                }
            }
        }
    }
?>
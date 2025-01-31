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

        public function renderTemplate(string $tmpname, ){
            require($this->viewsfolder . "{$tmpname}.view.php");
        }

        public function getView(string $view){
            if(!$this->currentUser || $this->currentUser && !$this->currentUser['UserID']){
                $this->renderTemplate('login');
            }else{
                if(isset($view) && $view !== '' && $view !== '?logout=1'){
                    if(!file_exists($this->viewsfolder . "{$view}.view.php")){
                        $this->renderTemplate('notfound');
                    }else{
                        $this->renderTemplate($view);
                    }
                }else if(!isset($view) || isset($view) && $view == ""){
                    $this->renderTemplate('home');
                }
            }
        }
    }
?>
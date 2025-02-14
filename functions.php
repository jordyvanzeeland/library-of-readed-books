<?php
    namespace App;
    use App\Controllers\Core\AuthController;

    class Functions{
        private $db;
        private $config;

        # Get database credentials from a JSON file
        # Then make a new PDO connection with the database

        public function DbConnect(){
            $configfile = file_get_contents("config.json") ;
            $this->config = json_decode($configfile);
            $this->db = new \PDO('mysql:dbname=' . $this->config->db_name . ';host=' . $this->config->db_host . ';charset=utf8mb4', $this->config->db_user, $this->config->db_pass); 
            return $this->db;
        }

        # Turn error reporting on or off

        public function debug(bool $switch){
            if($switch == true){
                error_reporting(E_ALL);
                ini_set('display_errors', 1);
            }
        }
    }
?>
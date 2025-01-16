<?php

namespace App\Controller;

# Controller for user authentication and authorization
# This is using the DelightIM/Auth package:
# https://github.com/delight-im/PHP-Auth

class AuthController{
    private $db;
    private $delightauth;
    private $config;

    public function __construct() {
        $configfile = file_get_contents("config.json") ;
        $this->config = json_decode($configfile);

        $this->db = new \PDO('mysql:dbname=' . $this->config->db_name . ';host=' . $this->config->db_host . ';charset=utf8mb4', $this->config->db_user, $this->config->db_pass); 
        $this->delightauth = new \Delight\Auth\Auth($this->db);
    }

    public function login(string $username, string $password){
        try {
            $this->delightauth->login($username, $password);
            die('User is logged in');
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            die('Wrong email address');
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            die('Wrong password');
        }
        catch (\Delight\Auth\EmailNotVerifiedException $e) {
            die('Email not verified');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
    }

    public function logout(){
        try {
            $this->delightauth->logOutEverywhereElse();
            $this->delightauth->destroySession();
        }
        catch (\Delight\Auth\NotLoggedInException $e) {
            die('Not logged in');
        }
    }

    public function register(string $email, string $password, string $username){
        try {
            $userId = $this->delightauth->register($email, $password, $username);
            die('Nieuwe gebruiker aangemeld');
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            die('Invalid email address');
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            die('Invalid password');
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            die('User already exists');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
    }

    public function getCurrentUser() {
        echo "Email: " . $this->delightauth->getEmail() . ", Username: " . $this->delightauth->getUsername();
    }
}
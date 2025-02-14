<?php

namespace App\Controller;
use App\Functions;

# Controller for user authentication and authorization
# This is using the DelightIM/Auth package:
# https://github.com/delight-im/PHP-Auth

class AuthController{
    private $db;
    private $delightauth;
    private $config;

    public function __construct() {
        $this->db = (new Functions())->DbConnect();
        $this->delightauth = new \Delight\Auth\Auth($this->db);
    }

    public function login(string $username, string $password){
        try {
            $this->delightauth->login($username, $password);
            echo json_encode($this->getCurrentUser());
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            echo 'Wrong email address';
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            echo 'Wrong password';
        }
        catch (\Delight\Auth\EmailNotVerifiedException $e) {
            echo 'Email not verified';
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            echo 'Too many requests';
        }
    }

    public function logout(){
        try {
            $this->delightauth->logOutEverywhereElse();
            $this->delightauth->destroySession();
            header("Refresh:0;url=/");
        }
        catch (\Delight\Auth\NotLoggedInException $e) {
            die('Not logged in');
        }
    }

    public function getCurrentUser() {
        if($this->delightauth->isLoggedIn()){
            return [
                "UserID" => $this->delightauth->getUserId(),
                "Username" => $this->delightauth->getUsername(),
                "Email" => $this->delightauth->getEmail()
            ];
        }
    }
}
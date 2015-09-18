<?php

/**
 * Created by PhpStorm.
 * User: Eleonor Lagerkrants
 * Date: 2015-09-17
 * Time: 13:33
 */
class Session {

    public function checkSession() {

        if (!isset($_SESSION))
            session_start();

        if(isset($_SESSION['username']) && isset($_SESSION['password'])) {
            return true;
        }
        else
            return false;
    }

    public function saveSessionUsername($username) {
        $_SESSION['username'] = $username;
    }

    public function saveSessionPassword($password) {
        $_SESSION['password'] = $password;
    }

    public function loadSessionUsername() {
        return $_SESSION['username'];
    }

    public function loadSessionPassword() {
        return $_SESSION['password'];
    }

}
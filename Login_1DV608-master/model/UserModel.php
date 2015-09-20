<?php

/**
 * Created by PhpStorm.
 * User: Eleonor Lagerkrants
 * Date: 2015-09-16
 * Time: 14:42
 */
class UserModel {
    private $name = "Admin";
    private $password = "Password";

    public function getUsername() {
        return $this->name;
    }

    public function getPassword() {
        return $this->password;
    }

    public function checkUser($user, $password) {
        if($user == $this->name && $password == $this->password)
            return true;
        else
            return false;
    }

}
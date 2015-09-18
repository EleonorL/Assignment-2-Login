<?php

/**
 * Created by PhpStorm.
 * User: Eleonor Lagerkrants
 * Date: 2015-09-17
 * Time: 12:16
 */

require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('model/UserModel.php');
require_once('model/Session.php');

class Controller {

    private $loginView;
    private $dateTimeView;
    private $layoutView;
    private $user;
    private $session;

    public function __construct()
    {
        $this->loginView = new LoginView();
        $this->dateTimeView = new DateTimeView();
        $this->layoutView = new LayoutView();
        $this->user = new UserModel();
        $this->session = new Session();

    }

    public function checkLogIn() {
        if($this->session->checkSession()) {
            $_SESSION['Logged'] = true;
            $this->session->loadSessionUsername();
            $this->session->loadSessionPassword();
        }
        elseif($this->loginView->getRequestUserName() === $this->user->getUsername() && $this->loginView->getRequestPassword() === $this->user->getPassword()) {
            $_SESSION['Logged'] = true;
        }
        else {
            $_SESSION['Logged'] = false;
        }
    }

    public function request() {
        $this->checkLogIn();
        $this->layoutView->render($_SESSION['Logged'], $this->loginView, $this->dateTimeView);
    }



}
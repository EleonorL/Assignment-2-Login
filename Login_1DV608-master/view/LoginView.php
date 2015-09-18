<?php

class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';

	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response() {
		$message = "";
		$username = "";
		$password = "";

		//check if login button pressed and then if username and password has been entered
		if( $this->getLogin()) {

			if($this->getRequestUserName() == "")
				$message = "Username is missing";

			else if ($this->getRequestPassword() == "") {
				$message = "Password is missing";
			}
			else {
				$user = new UserModel();
				if (!$user->checkUser($username, $password)) {
					$message = "Wrong name or password";
				}
				else {
					$_SESSION['Logged'] = true;
					$response = $this->generateLogoutButtonHTML($message);
				}
			}
		}
		else if($this->getLogout()) {
			session_destroy();
			$_SESSION['Logged'] = false;
			$message = "Bye bye!";
			$response = $this->generateLoginFormHTML($message);
		}


		if($_SESSION['Logged'] === true) {
			if($this->checkSession())
				$response = $this->generateLogoutButtonHTML($message);
			else {
				$message = "Welcome";
				$this->saveSession($username, $password);
				$response = $this->generateLogoutButtonHTML($message);
			}
		}
		else
			$response = $this->generateLoginFormHTML($message);

		//$response = $this->generateLoginFormHTML($message);
		//$response = $this->generateLogoutButtonHTML($message);
		return $response;
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLogoutButtonHTML($message) {
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}
	
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLoginFormHTML($message) {
		return '
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $this->getRequestUserName() .'" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}
	
	//CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES
	public function getRequestUserName() {
		if(isset($_POST[self::$name]))
			$username = $_POST[self::$name];
		else
			$username = "";
		return $username;
	}

	public function getRequestPassword() {
		if (isset($_POST[self::$password]))
			$password = $_POST[self::$password];
		else
			$password = "";
		return $password;
	}

	private function getLogin() {
		return (isset($_POST[self::$login]));
	}

	private function getLogout() {
		return (isset($_POST[self::$logout]));
	}

	private function saveSession($username, $password) {
		$s = new Session();
		$s->saveSessionUsername($username);
		$s->saveSessionPassword($password);
	}

	private function checkSession() {
		$s = new Session();
		return $s->checkSession();
	}

}
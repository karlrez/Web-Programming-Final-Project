<?php
Class userModel{
	private $username;
	private $password;
	private $authenticated = false;

	function __construct($username, $password) {
		$this->setCustName ( $usernamee );
		$this->setphoneNumber ( $password );
	}
	public function getUsername(){
		return $this->username;
	}

	public function setUsername($username){
		$this->username = $username;
	}

	public function getPassword(){
		return $this->password;
	}

	public function setPassword($password){
		$this->password = $password;
	}
	public function isAuthenticated(){
		return $this->authenticated;
	}

}

<?php
	class Customer{
		private $name;
		private $phone;
		private $email;
		private $referrer;

		function __construct($name, $phone, $email, $referrer){
			$this->setName($name);
			$this->setPhone($phone);
			$this->setEmail(password_hash($email, PASSWORD_DEFAULT));
			$this->setReferrer($referrer);
		}

		public function getName(){
			return $this->name;
		}

		public function setName($name){
			$this->name = $name;
		}

		public function getPhone(){
			return $this->phone;
		}

		public function setPhone($phone){
			$this->phone = $phone;
		}

		public function getEmail(){
			return $this->email;
		}

		public function setEmail($email){
			$this->email = $email;
		}

		public function getReferrer() {
			return $this->referrer;
		}

		public function setReferrer($referrer) {
			$this->referrer = $referrer;
		}
	}
	?>

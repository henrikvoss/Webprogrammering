<?php
class Customer {
	private $email;
	private $firstName;
	private $surname;
	private $address;
	private $postalCode;
	private $city;
	private $country;

	function __construct($em, $fi, $su, $ad, $po, $ci, $co) {
		$this->email = $em;
		$this->firstName = $fi;
		$this->surname = $su;
		$this->address = $ad;
		$this->postalCode = $po;
		$this->city = $ci;
		$this->country = $co;
	}

	public function getEmail() {
		return $email;
	}

	public function getFirstName() {
		return $firstName;
	}

	public function getSurname() {
		return $surname;
	}

	public function getAddress() {
		return $address;
	}

	public function getPostalCode() {
		return $postalCode;
	}

	public function getCity() {
		return $city;
	}

	public function getCountry() {
		return $country;
	}
}
?>

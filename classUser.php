<?php
class User {
	private $email;
	private $firstName;
	private $surname;
	private $address;
	private $postalCode;
	private $city;
	private $country;

	/**
	 * Hvis det ikke sendes med parametere henter konstruktøren selv det 
	 * aktuelle fra databasen.
	 */
	function __construct($pEmail) {
		/* Ingen parametere sendt til konstruktøren. Dvs. brukeren eksisterer fra før.
		 * Konstruktøren henter alt fra databasen. */
		$this->email = $pEmail;
		$userdata =
			$_SESSION["database"]->selectQuery("select * from Customer where email='".$this->email."';");
		$this->firstName = $userdata[0]->firstname;
		$this->surname = $userdata[0]->surname;
		$this->address = $userdata[0]->address;
		$this->postalCode = $userdata[0]->postalcode;
		$this->city = $userdata[0]->city;
		$this->country = $userdata[0]->country;
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

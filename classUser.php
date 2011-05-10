<?php
class User {
	private $email;
	private $firstName;
	private $surname;
	private $address;
	private $postalCode;
	private $city;
	private $country;
	private $admin;

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

		$this->admin = $_SESSION["database"]->checkIfAdmin($this->email);
	}

	public function getEmail() {
		return $this->email;
	}

	public function getFirstName() {
		return $this->firstName;
	}

	public function getSurname() {
		return $this->surname;
	}

	public function getAddress() {
		return $this->address;
	}

	public function getPostalCode() {
		return $this->postalCode;
	}

	public function getCity() {
		return $this->city;
	}

	public function getCountry() {
		return $this->country;
	}

	public function getIfAdmin() {
		return $this->admin;
	}
}
?>

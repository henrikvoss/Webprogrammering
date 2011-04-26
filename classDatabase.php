<?php

class Database {
	private $host;
	private $user;
	private $password;
	private $DBName;

	function __construct($h, $u, $p, $dn) {
		$this->host = $h;
		$this->user = $u;
		$this->password = $p;
		$this->DBName = $dn;
	}

	/**
	 * Sett $db til denne funksjonen i starten av hver funksjon for å 
	 * opprette et mysqli-objekt.
	 */
	private function connectToDB() {
		$db = new mysqli($host, $user, $password, $DBName);
		if ( !$db ) {
			die("<p>Not able to connect to the database: ".$db->connect_error."</p>");
		}
		return $db;
	}

	public function selectQuery($sql) {
		$db = $this->connectToDB();
		$resultat = $db->query($sql);

		if ( !$resultat ) {
			echo "<p>Error in connection to the database.</p>";
			return false;
		}
		else {

			$antallRader = $db->affected_rows;
			$table = array();

			for ( $i = 0; $i < $antallRader; $i++ ) {
				$row = $resultat->fetch_object();
				$table[$i] = $row;
			}

			return $table;
		}
	}
	
	public function addData($em, $pass, $first, $sur, $add, $post, $city, $country) {
		$db = $this->connectToDB();
		$sql = "Insert into Customer (email, password, firstname, surname, address, postalcode, city, country) values ('$em', '$pass', '$first', '$sur', '$add', '$post', '$city', '$country')";
		$resultat ? $db->query($sql);
		if(!$resultat)
		{
			return false;
		}
		else
		{
			if(($db->affected_rows) == 0)
			{
				return false;
			}
			else
			{
				return true;
			}
		}	
	}
}

?>

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
		$db =
			new mysqli($this->host,$this->user,$this->password,$this->DBName);

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
	
	public function addUserData($em, $pass, $first, $sur, $add, $post, $city, $country) {
		$db = $this->connectToDB();
		$sql = "Insert into Customer (email, password, firstname, surname, address, postalcode, city, country) values ('$em', '$pass', '$first', '$sur', '$add', '$post', '$city', '$country')";
		$resultat = $db->query($sql);

		if(!$resultat)
		{
			echo $db->error;
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

	/*
	public function inTable($x, $table, $col) {
		$db = $this->connectToDB();
		$sql = "select * from ".$table." where '".$x."' = ".$col;
		$result = $db->query($sql);

		if(!$result)
		{
			echo $db->error;
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
	*/

	public function checkUser($name, $pas) {
		$db = connectToDB();

		if ( $db ) {
			$sql = "select * from Customer where '".$name."' = Username";
			$result = $db->query($sql);

			if(!$result) {
				echo "<p>".$db->error."</p>";
				return false;
			}else {
				if(($db->affected_rows) == 0) {
					echo "<p>Non existing user.</p>";
					return false;
				}else {
					/* Passord sjekk her: */
					$sql = "select * from Customer where '".$pas."' = Password";
					$result = $db->query($sql);

					if ( !$result ) {
						echo "<p>".$db->error."</p>";
						return false;
					} else {
						if(($db->affected_rows) == 0) {
							echo "<p>Wrong password.</p>";
							return false;
						}else {
							return true;
						}
					}
				}
			}
			
		}
	}	
}

?>

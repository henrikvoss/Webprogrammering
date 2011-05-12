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

	private function hashString($pas) {
		return sha1($pas);
	}

	public function addUserData($em, $pass, $first, $sur, $add, $post, $city, $country) {
		$db = $this->connectToDB();
		$sql = "Insert into Customer (email, password, firstname, surname, address, postalcode, city, country) values ('$em', '".$this->hashString($pass)."', '$first', '$sur', '$add', '$post', '$city', '$country')";
		$resultat = $db->query($sql);

		if(!$resultat) {
			echo $db->error;
			return false;
		}
		else {
			if(($db->affected_rows) == 0) {
				return false;
			}
			else {
				return true;
			}
		}
	}

	public function addToDB($style) {
		$db = $this->connectToDB();

		if ( $db ) {
			$sql = "insert into Style values ('".$style->getName()."', '".$style->getSeason()."', ".$style->getPrice().", ".$style->getStock().", '".$style->getImage()."')";
			$result = $db->query($sql);

			if ( !$result ) {
				echo "<p>Style could not be added to the database. Error in query.</p>";
				return false;
			} else {
				if ( ($db->affected_rows) == 0 ) {
					return false;
				} else {
					return true;
				}				
			}
		}
	}

	public function checkIfAdmin($user) {
		$db = $this->connectToDB();
		
		if ( $db ) {
			$sql ="select email from Admin where email='".$user."'";
			$result = $db->query($sql);

			if ( !$result ) {
				echo "<p>Could not check if you are admin: ".$db->error."</p>";
				return false;
			} else {
				if ( ($db->affected_rows) == 0 ) {
					return false;
				} else {
					return true;
				}
			}
		}
	}

	/*
 	 * Metode som validerer om brukernavn og passord er riktig.
	 * Oppretter ikke bruker-objekt.
	 * 
	 */
	public function checkUser($name, $pas) {
		$db = $this->connectToDB();

		if ( $db ) {
			$sql = "select * from Customer where '".$name."' = email";
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
					$sql = "select * from Customer where '".$this->hashString($pas)."' = password";
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

	public function selectQuery($sql) {
		$db = $this->connectToDB();
		$result= $db->query($sql);

		if ( !$result) {
			echo "<p>Error in connection to the database.</p>";
			return false;
		}
		else {

			$antallRader = $db->affected_rows;
			$table = array();

			if ( $antallRader == 0 ) {
				return false;
				break;
			}
			else {
				for ( $i = 0; $i < $antallRader; $i++ ) {
					$row = $result->fetch_object();
					$table[$i] = $row;
				}
				return $table;
			}
		}
	}

	public function updateDB($n,$s,$p,$st,$i) {
		$db = $this->connectToDB();

		if ( $db ) {
			$sql = "update Style set stylename = '$n', season = '$s', pricePerStyle = $p, stock = $st, image = '$i' where stylename = '$n'";
			$result = $db->query($sql);

			if ( !$result ) {
				echo "<p>Style could not be updated. Error in query.</p>";
				echo "<p>".$db->error."</p>";
				return false;
			} else {
				if ( ($db->affected_rows) == 0 ) {
					echo "<p>No changes to style.</p>";
					return false;
				} else {
					return true;
				}				
			}
		}
	}
}

?>

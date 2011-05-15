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
			$sql = "insert into Style values ('".$style->getName()."', '".$style->getSeason()."', ".$style->getPrice().", ".$style->getNewStock().", '".$style->getImage()."')";
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
		$name = mysql_real_escape_string($name);
		$pas = mysql_real_escape_string($pas);

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

	public function delete($sql) {
		$db = $this->connectToDB();

		$result = $db->query($sql);

		if ( !$result ) {
			echo "<p>Error in delete query. ";
			echo $db->error."</p>";
			return false;
		} else {
			if ( ($db->affected_rows) == 0 ) {
				echo "<p>Nothing was deleted.</p>";
				return false;
			} else {
				return true;
			}				
		}
	}

	public function getAllSeasons() {
		$db = $this->connectToDB();
		$sql = "select distinct season from Style";
		$result = $db->query($sql);

		if ( !$result ) {
			echo "<p>Error in sql-query for getting all collection seasons.</p>";
			echo "<p>".$db->error."</p>";
			return false;

		} else if ( $db->affected_rows == 0 ) {
			return false;

		} else {
			$seasons = array();

			for ( $i = 0; $i < $db->affected_rows; $i++ ) {
				$seasonName = $result->fetch_object();
				$seasonName = $seasonName->season;
				$seasons[$i] = $seasonName;
			}

			return $seasons;
		}
	}

	public function getOrdersTable() {
		$db = $this->connectToDB();
		$sql = "select * from History order by date desc";
		$result = $db->query($sql);

		if ( !$result) {
			echo "<p>Error in sql-query.</p>";
			echo "<p>".$db->error."</p>";
			return false;

		} else {

			$antallRader = $db->affected_rows;
			$table = array();

			if ( $antallRader == 0 ) {
				return false;
			} else {

				for ( $i = 0; $i < $antallRader; $i++ ) {
					$row = $result->fetch_object();
					$table[$i] = $row;
				}

				return $table;
			}
		}
	}

	public function getNumberOfItems() {
		$db = $this->connectToDB();
		$sql = "select stylename from Style";
		$result = $db->query($sql);

		if ( !$result ) {
			echo "<p>Error in query for orderno.</p>";
			echo "<p>".$db->error."</p>";
			return 0;
		} else {
			return $db->affected_rows;
		}
	}

	public function getVar($sql) {
		$db = $this->connectToDB();
		$result= $db->query($sql);

		if ( !$result) {
			echo "<p>Error in sql-query.</p>";
			echo "<p>".$db->error."</p>";
			return false;

		} else {
			$antallRader = $db->affected_rows;

			if ( $antallRader == 0 ) {
				return false;
			}
			else if ( $antallRader == 1 ) {
				$row = $result->fetch_object();
				return $row->stock;
			}
			else {
				return false;
			}
		}
	}

	public function getNewOrderNo() {
		$db = $this->connectToDB();
		$orderno;
		$sql = "select orderno from History";
		$result = $db->query($sql);

		if ( !$result ) {
			echo "<p>Error in query for orderno.</p>";
			echo "<p>".$db->error."</p>";
			return false;
		} else {
			return $db->affected_rows + 1;
		}
	}

	public function insertQuery($sql) {
		$db = $this->connectToDB();

		$result = $db->query($sql);

		if ( !$result ) {
			echo "<p>Error in insert query.</p>";
			echo "<p>".$db->error."</p>";
			return false;
		} else if ( $db->affected_rows == 0 ) {
			echo "<p>Orderline $key was inserted.</p>";
			return false;
		} else {
			return true;
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

	public function update($sql) {
		$db = $this->connectToDB();

		$result = $db->query($sql);

		if ( !$result ) {
			echo "<p>Stock could not be updated. Error in query. ";
			echo $db->error."</p>";
			return false;
		} else {
			if ( ($db->affected_rows) == 0 ) {
				echo "<p>No updates made.</p>";
				return false;
			} else {
				return true;
			}				
		}

	}

	public function updateDB($n,$s,$p,$st,$i) {
		$db = $this->connectToDB();

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

?>

<?php include('controller.php'); ?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />

	<meta name="description" content="Shop at VATLE." />

	<title>VATLE - Webshop login</title>

	<?php addLinkTags(); ?>
</head>

<body>
	<?php	printHeader(); ?>
	<section class="text">

<?php

if (isset($_REQUEST["login"])) {

	if ( $_SESSION["database"]->checkUser($_REQUEST["username"],$_REQUEST["password"]) ) {
		setUser($_REQUEST["username"]);
		/* så sjekker controller.php:
		 * Sjekker om bruker er admin i classCustomer-konstruktøren.  
		 **/
	}

} else if(isset($_REQUEST["addNewUser"]))	{
	$_SESSION['database']->addUserData($_POST['email'],$_POST['password'], $_POST['first'], $_POST['surname'], $_POST['address'], $_POST['postalcode'], $_POST['city'], $_POST['country']);
	setUser($_REQUEST["email"]);
}



if (!isset($_SESSION["user"])) {
?>

<h1>Login</h1>

<form id="login" action="index.php" method="post">
	<table border="0" cellspacing="5" cellpadding="5">
		<tr>
			<td>Email:</td>
			<td><input type = "text" name = "username" size = 40></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input type = "password" name = "password" size = 40></td>
		</tr>
		<tr>
			<td><input type = "submit" name = "login" value = "Login"/></td>
		</tr>
	</table>
</form>

<p class="floatRight"><a href="register.php">Not registered?</a></p>
<?php
} else {

	/* DASHBOARD TO BROWSE AND UPDATE ITEMS */
	if ( $_SESSION["user"]->getIfAdmin() ) {
		?><h1>Browse and update items</h1><?php
	} else {
		?><h1>Browse items</h1><?php
	}
?>

<form id="request" action="index.php" method="post" >
	<table border="0" >
		<tr>
			<td>Choose style:</td>
			<td align="right">
				<select name="season">
					<option value="none">--Choose a season</option>
					<option value="SS2010">Spring/Summer 2010</option>
				</select>
			</td>

			<td>Price range:</td>
			<td align="right">
				<select name="price">
					<option value="none">--Choose price range</option>
					<option value="low">Low (0-&gt;1499)</option>
					<option value="medium">Medium (1500-&gt;2999)</option>
					<option value="high">High (3000-&gt;)</option>
				</select>
			</td>

			<td>Show wares:</td>
			<td><input type="submit" name="listStyles" VALUE="Show"></td>
		</tr>
	</table>
</form>

<?php
	if ( isset($_REQUEST["listStyles"]) ) {
		$sql = "select image,stylename,pricePerStyle from Style";

		$seasonChosen = false;
		if ( $_REQUEST["season"] != "none" ) {
			$seasonChosen = true;
			$sql .= " where season='".$_REQUEST['season']."'";
		}

		if ( $_REQUEST["price"] != "none" ) {
			if ($seasonChosen) $sql .= " and pricePerStyle ";
			else $sql .= " where pricePerStyle ";
			/* Add to query what price ranges using if-loops. */
			if ( $_REQUEST["price"] == "low" ) {
				$sql .= "between 0 and 1499";
			} else if ( $_REQUEST["price"] == "medium" ) {
				$sql .= "between 1500 and 2999";
			} else {
				$sql .= "> 3000";
			}
		}

		$styles = $_SESSION["database"]->selectQuery($sql);

		/* TODO: print $styles */
	}

}


printFooter();
?>

</section>
</body>

</html>


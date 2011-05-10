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
	if ( !$_SESSION["user"]->getAdmin() ) {
?>

<!-- USER DASHBOARD -->
<h1>Here you can browse the items in the webshop.</h1>

<form id="request" action="index.php" method="post" >
	<table border="0" >
		<tr>
			<td>Choose style:</td>
			<td align="right">
				<select name="style">
					<option value="choose">--Choose a style--</option>
					<option value="20SS10">Spring/Summer</option>
				</select>
			</td>
			<td>Price range:</td>
			<td align="right">
				<select name="price">
					<option value="low">Low (0-&gt;1499)</option>
					<option value="medium">Medium (1500-&gt;2999)</option>
					<option value="high">Low (3000-&gt;)</option>
				</select>
			</td>
			<td>Show wares:</td>
			<td><input type="submit" name="show" VALUE="Show"></td>
		</tr>
	</table>
</form>

<?php

	} else {
?>
<!-- ADMIN DASHBOARD -->
<?php
	}
}


printFooter();
?>

</section>
</body>

</html>


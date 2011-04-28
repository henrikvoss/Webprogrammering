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
	</section>

<?php  

if (isset($_REQUEST["login"])) {

	/* TODO: */
	/* Skrive ut beskjed til kunden om gammel bruker eller ikke eksiterer. */
	if ( $_SESSION["database"]->checkUser($_REQUEST["username"],$_REQUEST["password"]) ) {
		$_SESSION["user"] = getCustomer($_REQUEST["username"]);
		/* Neste steg i controller.php:
		 * Sjekker om bruker er admin i classCustomer-konstruktøren.  
		 * controller.php henter alle
		 * data fra databasen for å opprette kunde-objektet.
		 **/
	}
}

printFooter();
?>

</body>

</html>


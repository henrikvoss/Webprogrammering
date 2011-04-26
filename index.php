<?php include('controller.php'); ?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />

	<meta name="description" content="Shop at VATLE." />

	<meta name="keywords" content="shop, webshop, Vatle,
	clothing, women&#39;s clothing, soon men&#39;s clothing, designer clothing, Vatle
	designs" />

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
	$_SESSION['Database'] =
		new Database('cube.iu.hio.no', 's171172', '', 's171172');

	/* TODO: */
	/* Skrive ut beskjed til kunden om gammel bruker eller ikke eksiterer. */
	if ( $_SESSION["Database"]->inTable($_REQUEST["username"], $Customer, "email") ) {
		$_SESSION['user'] = new Customer($_REQUEST["username"]);
		/* Neste steg i classCustomer.php:
 		 * Sjekker om bruker er admin i konstruktøren og henter alle
		 * data fra databasen for å opprette kunde-objektet. */
	}
}

printFooter();
?>

</body>

</html>


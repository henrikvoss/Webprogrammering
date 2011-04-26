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
		
		<?php  
		
		if(isset($_REQUEST["Register"]))
		{
			$_SESSION['Database'] =
				new Database('cube.iu.hio.no', 's171172', '', 's171172');

			/* Sjekker om bruker som logger på eksisterer og om er admin. */
			if ( $_SESSION["Database"]->logIn() ) {
				/* cursor */
			}
		}
		else
		{
		?>
		
		<form id="login" action="index.php" method="post">
			<table border="0" cellspacing="5" cellpadding="5">
				<tr>
					<td>Username:</td>
					<td><input type = "text" name = "username" size = 40></td>
				</tr>
				<tr>
					<td>Password:</td>
					<td><input type = "password" name = "password" size = 20></td>
				</tr>
				<tr>
					<td><input type = "submit" value = "Login"/></td>
				</tr>
			</table>
		</form>
		
		<form id="register" action="register.php" method="post">
			<table border="0" cellspacing="5" cellpadding="5">
				<tr><td><input type = "submit" value = "Register"/></td></tr>
			</table>
		</form>
		<?php 
			}		
		?>
	</section>
	
	<?php printFooter();	?>
</body>

</html>


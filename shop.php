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
		
		<form id="login" action="" method="post">
			<table border="0" cellspacing="5" cellpadding="5">
				<tr>
					<td>Username:</td>
					<td><input type = "text" name = "username" size = 30></td>
				</tr>
				<tr>
					<td>Password:</td>
					<td><input type = "password" name = "password" size = 15></td>
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
		
	</section>
	
	<?php printFooter();	?>
</body>

</html>


<?php include('controller.php'); ?>
<!DOCTYPE HTML>

<html>

<head>
	<meta charset="UTF-8" />

	<meta name="description" content="Register at VATLE." />

	<title>VATLE - Register at VATLE's webshop</title>

	<?php addLinkTags(); ?>
</head>

<body>
	<?php printHeader(); ?>

	<section class="text">

		<h1>Register with VATLE</h1>

<?php  
if (!isset($_SESSION["user"])) {

?>
<form id="register" action="index.php" method="post">
	<table border="0" >
		<tr>
			<td>First name:</td>
			<td><input type="text" name="first"></td>
		</tr>
		<tr>
			<td>Surname:</td>
			<td><input type="text" name="surname"></td>
		</tr>
		<tr>
			<td>Address:</td>
			<td><input type="text" name="address"></td>
		</tr>
		<tr>
			<td>City/State:</td>
			<td><input type="text" name="city"></td>
		</tr>
		<tr>
			<td>Zip code:</td>
			<td><input type="text" name="postalcode"></td>
		</tr>
		<tr>
			<td>Country:</td>
			<td><input type="text" name="country"></td>
		</tr>
		<tr>
			<td>E-mail:</td>
			<td><input type="text" name="email"></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input type="password" name="password"></td>
		</tr>				
		<tr><td><input type="submit" name="addNewUser" VALUE="Register"></td></tr>
	</table>

</form>
<?php 
} else {
?><p><a href="logout.php">Logout</a> or 
	<a href="index.php">continue shopping</a></p><?php
}
?>
		</section>

		<?php printFooter(); ?>
	</body>

	</html>

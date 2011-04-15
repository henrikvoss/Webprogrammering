<?php include('controller.php'); ?>
<!DOCTYPE HTML>

<html lang="en">
	
	<head>
		<meta charset="UTF-8" />

		<meta name="description" content="Register at VATLE." />

		<meta name="keywords" content="contact, Vatle,
		clothing, women&#39;s clothing, soon men&#39;s clothing, designer clothing, Vatle
		designs" />
		
		<title>VATLE - Register at Vatle's webshop</title>
		
		<?php addLinkTags(); ?>
	</head>
	
	<body>
		<?php printHeader(); ?>
		
		<section class="text">
		
		<h1>Register with VATLEdesign</h1>
		
		<form id="register" action="" method="post">
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
		        <td>Telephone:</td>
		        <td><input type="text" name="tlf"></td>
		      </tr>
		      <tr>
		        <td>E-mail:</td>
		        <td><input type="text" name="email"></td>
		      </tr>
				<tr>
		        <td>Password:</td>
		        <td><input type="text" name="password"></td>
		      </tr>				
		      <tr><td><input type="submit" name="send" VALUE="Register"></td></tr>
		     </table>
			
		</form>
		</section>
		
		<?php printFooter(); ?>
	</body>

</html>
<?php include('controller.php'); ?>
<!DOCTYPE HTML>

<html>

<head>
	<meta charset="UTF-8" />

	<meta name="description" content="Register at VATLE." />

	<title>VATLE - Register at VATLE's webshop</title>

	<?php addLinkTags(); ?>
	
	<script type="text/javascript">
		
		function validate_first()
		{
			regEx = /^[a-zA-ZæøåÆØÅ .\-](2,20)$/;
			OK = regEx.test(document.myForm.first.value);
			if(!OK)
			{
				document.getElementById("wrongFirst").innerHTML="Error in your input.";
				return false;
			}
			document.getElementById("wrongFirst").innerHTML="";
			return true;
		}
		
		function validate_surname()
		{
			regEx = /^[a-zA-ZæøåÆØÅ .\-](2,20)$/;
			OK = regEx.test(document.myForm.surname.value);
			if(!OK)
			{
				document.getElementById("wrongSurname").innerHTML="Error in your input.";
				return false;
			}
			document.getElementById("wrongSurname").innerHTML="";
			return true;
		}
		
		function validate_address()
		{
			regEx = /^[a-zA-ZæøåÆØÅ0-9 .\-](2,30)$/;
			OK = regEx.test(document.myForm.address.value);
			if(!OK)
			{
				document.getElementById("wrongAddress").innerHTML="Error in your input.";
				return false;
			}
			document.getElementById("wrongAddress").innerHTML="";
			return true;
		}
		
		function validate_city()
		{
			regEx = /^[a-zA-ZæøåÆØÅ .\-](2,20)$/;
			OK = regEx.test(document.myForm.city.value);
			if(!OK)
			{
				document.getElementById("wrongCity").innerHTML="Error in your input.";
				return false;
			}
			document.getElementById("wrongCity").innerHTML="";
			return true;
		}
		
		function validate_postalcode()
		{
			regEx = /^[0-9 .\-](4,8)$/;
			OK = regEx.test(document.myForm.postalcode.value);
			if(!OK)
			{
				document.getElementById("wrongPostalcode").innerHTML="Error in your input.";
				return false;
			}
			document.getElementById("wrongPostalcode").innerHTML="";
			return true;
		}
		
		function validate_country()
		{
			regEx = /^[a-zA-ZæøåÆØÅ .\-](2,15)$/;
			OK = regEx.test(document.myForm.country.value);
			if(!OK)
			{
				document.getElementById("wrongCountry").innerHTML="Error in your input.";
				return false;
			}
			document.getElementById("wrongCountry").innerHTML="";
			return true;
		}
		
		function validate_email()
		{
			regEx = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			OK = regEx.test(document.myForm.email.value);
			if(!OK)
			{
				document.getElementById("wrongEmail").innerHTML="Error in your input.";
				return false;
			}
			document.getElementById("wrongEmail").innerHTML="";
			return true;
		}
		
		function validate_all()
		{
			firstOK = validate_first();
			surnameOK = validate_surname();
			addressOK = validate_address();
			cityOK = validate_city();
			postalcodeOK = validate_postalcode();
			countryOK = validate_country();
			emailOK = validate_email();
			
			if(firstOK && surnameOK && addressOK && cityOK && postalcodeOK && countryOK && emailOK)
			{
				return true;
			}
			return false;
		}
	</script>
	
</head>

<body>
	<?php printHeader(); ?>

	<section class="text">

		<h1>Register with VATLE</h1>

<?php  
if (!isset($_SESSION["user"])) {

?>
<form action="index.php" name="myForm" onsubmit="return validate_all()" method="post">
	<table border="0" >
		<tr>
			<td>First name:</td>
			<td><input type="text" name="first" onChange="validate_first()"></td>
			<td><div id="wrongFirst">*</div></td>
		</tr>
		<tr>
			<td>Surname:</td>
			<td><input type="text" name="surname" onChange="validate_surname()"></td>
			<td><div id="wrongSurname">*</div></td>
		</tr>
		<tr>
			<td>Address:</td>
			<td><input type="text" name="address" onChange="validate_address()"></td>
			<td><div id="wrongAddress">*</div></td>
		</tr>
		<tr>
			<td>City/State:</td>
			<td><input type="text" name="city" onChange="validate_city()"></td>
			<td><div id="wrongCity">*</div></td>
		</tr>
		<tr>
			<td>Zip code:</td>
			<td><input type="text" name="postalcode" onChange="validate_postalcode()"></td>
			<td><div id="wrongPostalcode">*</div></td>
		</tr>
		<tr>
			<td>Country:</td>
			<td><input type="text" name="country" onChange="validate_country"></td>
			<td><div id="wrongCountry">*</div></td>
		</tr>
		<tr>
			<td>E-mail:</td>
			<td><input type="text" name="email" onChange="validate_email"></td>
			<td><div id="wrongEmail">*</div></td>
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

<?php include("controller.php"); ?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />
	<title>
		VATLE - Webshop - Add a new item
	</title>
	<?php addLinkTags(); ?>
	<script type="text/javascript" charset="utf-8">
		function validate_name()
		{
			regEx = /^[a-zA-ZæøåÆØÅ .\-](2,30)$/;
			OK = regEx.test(document.addItems.itemName.value);
			if(!OK)
			{
				document.getElementById("wrongName").innerHTML="Error in your input. Only use letters."
				return false;
			}
			document.getElementById("wrongName").innerHTML="";
			return true;
		}
		
		function validate_season()
		{
			regEx = /^[a-zA-ZæøåÆØÅ .\-](2,30)$/;
			OK = regEx.test(document.addItems.itemSeason.value);
			if(!OK)
			{
				document.getElementById("wrongSeason").innerHTML="Error in your input. Only use letters and numbers"
				return false;
			}
			document.getElementById("wrongSeason").innerHTML="";
			return true;
		}
		
		function validate_price()
		{
			regEx = /^[0-9](2,10)$/;
			OK = regEx.test(document.addItems.itemPrice.value);
			if(!OK)
			{
				document.getElementById("wrongPrice").innerHTML="Error in your input. Only use numbers"
				return false;
			}
			document.getElementById("wrongPrice").innerHTML="";
			return true;
		}
		
		function validate_instock()
		{
			regEx = /^[0-9](2,10)$/;
			OK = regEx.test(document.addItems.inStock.value);
			if(!OK)
			{
				document.getElementById("wrongInStock").innerHTML="Error in your input. Only use numbers"
				return false;
			}
			document.getElementById("wrongInStock").innerHTML="";
			return true;
		}
		
		function validate_all()
		{
			nameOK = validate_name();
			seasonOK = validate_season();
			priceOK = validate_price();
			instockOK = validate_instock();
			if(nameOK && seasonOK && priceOK && instockOK)
			{
				return true;
			}
			return false;
		}
	</script>
</head>

<body>
	<?php	printHeader(); ?>
	<section class="text">

<?php
if ( isset($_SESSION["user"]) ) {
	if ( $_SESSION["user"]->getIfAdmin() ) {
?>

<h1>Add a new item</h1>

<form enctype="multipart/form-data" name="addItems" action="newItem.php" method="post" onsubmit="return validate_all()">
	<table border="0" cellspacing="5" cellpadding="5">
		<tr>
			<td>Item name:</td>
			<td><input type="text" name="itemName" onChange="validate_name()"></td>
			<td><div id="wrongName">*</div></td>
			<td>Season:</td>
			<td><input type="text" name="itemSeason" onChange="validate_season()"></td>
			<td><div id="wrongSeason">*</div></td>
		</tr>
		<tr>
			<td>Price:</td>
			<td><input type="text" name="itemPrice" onChange="validate_price()"></td>
			<td><div id="wrongPrice">*</div></td>
			<td>In Stock:</td>
			<td><input type="text" name="inStock" onChange="validate_instock()"></td>
			<td><div id="wrongInStock">*</div></td>
		</tr>
		<tr>
			<td><input type="hidden" name="MAX_FILE_SIZE" value="1000000">
		</tr>
	</table>
	<table>
		<tr>
			<td>Choose a file to upload:<input name="uploadedImg" type="file"><input type="submit" name="addItem" value="Upload Item"></td>
	</table>
</form>

<?php

		if ( isset($_REQUEST["addItem"]) ) {
			$imageUrl = "Images/Lookbook/";
			$imageUrl .= basename($_FILES["uploadedImg"]["name"]);

			if(move_uploaded_file($_FILES['uploadedImg']['tmp_name'], $imageUrl)) {
				echo "<p>The image ".basename( $_FILES['uploadedImg']['name']). 
					" has been uploaded.</p>";
			} else{
				echo "<p>There was an error uploading your image, please try again.</p>";
			}
			
			$newItem = new Style($_REQUEST["itemName"], $_REQUEST["itemSeason"], $_REQUEST["itemPrice"], $_REQUEST["inStock"], $imageUrl);
			if ($_SESSION["database"]->addToDB($newItem)) {
				$_SESSION["style"][count($_SESSION["style"])] = $newItem;
			}
		}
	} else {
		?><a href="index.php">Go to shop</a><?php
	}
} /* END if( isset(session[user]) ) */
else {
	?><a href="index.php">Go to shop</a><?php
}
?>

	</section><!-- End text class -->
	<?php printFooter(); ?>
</body>

</html>


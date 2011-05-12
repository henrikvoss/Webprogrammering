<?php include("controller.php"); ?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />
	<title>
		VATLE - Webshop - Add a new item
	</title>
	<?php addLinkTags(); ?>
	<script type="text/javascript">
		
		function validate_name()
		{
			regEx = /^[a-zA-ZæøåÆØÅ0-9 .\-]{1,30}$/;
			OK = regEx.test(document.addItems.itemName.value);
			if(!OK)
			{
				document.getElementById("wrongName").innerHTML="Error in your input. Only use letters.";
				return false;
			}
			document.getElementById("wrongName").innerHTML="";
			return true;
		}
		
		function validate_season()
		{
			regEx = /^[a-zA-ZæøåÆØÅ .\-]{1,30}$/;
			OK = regEx.test(document.addItems.itemSeason.value);
			if(!OK)
			{
				document.getElementById("wrongSeason").innerHTML="Error in your input.";
				return false;
			}
			document.getElementById("wrongSeason").innerHTML="";
			return true;
		}
		
		function validate_price()
		{
			regEx = /^[0-9]{1,10}$/;
			OK = regEx.test(document.addItems.itemPrice.value);
			if(!OK)
			{
				document.getElementById("wrongPrice").innerHTML="Error in your input.";
				return false;
			}
			document.getElementById("wrongPrice").innerHTML="";
			return true;
		}
		
		function validate_instock()
		{
			regEx = /^[0-9]{1,10}$/;
			OK = regEx.test(document.addItems.inStock.value);
			if(!OK)
			{
				document.getElementById("wrongInStock").innerHTML="Error in your input.";
				return false;
			}
			document.getElementById("wrongInStock").innerHTML="";
			return true;
		}
		
		function validate_image()
		{
			regEx = /^[a-zA-ZæøåÆØÅ0-9]{1,20}$/;
			OK = regEx.test(document.addItems.file.value);
			if(!OK)
			{
				document.getElementById("wrongImage").innerHTML="You must choose an image.";
				return false;
			}
			document.getElementById("wrongImage").innerHTML="";
			return true;
		}
		
		function validate_all()
		{
			nameOK = validate_name();
			seasonOK = validate_season();
			priceOK = validate_price();
			instockOK = validate_instock();
			imageOK = validate_image();
			if(nameOK && seasonOK && priceOK && instockOK && imageOK)
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

		$changeItem = false;
		$styleKey;
		$changeStyle;

		foreach ($_SESSION["style"] as $key=>$value) {
			if ( isset($_REQUEST[$key]) ) {
				$changeItem = true;
				$changeStyle = $value;
				$styleKey = $key;
				break 1;/* Stop foreach loop */
			}
		}

		if (!$changeItem) {
?>

<h1>Add a new item</h1>

<form enctype="multipart/form-data" name="addItems" action="newItem.php" onsubmit="return validate_all()" method="post">
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
			<td><input type="hidden" name="file" value="1000000" onChange="validate_image()">
			</tr>
		</table>
		<table border="0" cellspacing="5" cellpadding="5">
			<tr>
				<td>Choose a file to upload:<input type="file" name="uploadedImg"></td>
				<td><div id="wrongImage"></div></td>
				
				<td><input type="submit" name="addItem" value="Upload Item">
				</td>
			</tr>
			</table>
		</form>

<?php
		} else {
?>

<form enctype="multipart/form-data" action="newItem.php" method="post">
	<table border="0" cellspacing="5" cellpadding="5">
		<tr>
			<td>Item name:</td>
			<input type="hidden" name="styleKey" value="<?php echo $styleKey; ?>" />
			<td><input type="text" name="itemName" value="<?php echo $changeStyle->getName(); ?>"></td>
			<td>Season:</td>
			<td><input type="text" name="itemSeason" value="<?php echo $changeStyle->getSeason(); ?>"></td>
		</tr>
		<tr>
			<td>Price:</td>
			<td><input type="text" name="itemPrice" value="<?php echo $changeStyle->getPrice(); ?>"></td>
			<td>In Stock:</td>
			<td><input type="text" name="inStock" value="<?php echo $changeStyle->getStock(); ?>"></td>
		</tr>
		<tr>
			<td><input type="hidden" name="MAX_FILE_SIZE" value="1000000">
			</tr>
		</table>
		<table>
			<tr>
				<td>Upload a new file:<input value="<?php echo $changeStyle->getImage(); ?>" name="uploadedImg" type="file">
					<input type="submit" name="changeItem" value="Change Item">
				</td>
			</tr>
		</table>
	</form>

<?php
		}

		if ( isset($_REQUEST["addItem"]) ) {

			$imageUrl = "Images/Lookbook/";
			$imageUrl .= basename($_FILES["uploadedImg"]["name"]);

			if(move_uploaded_file($_FILES['uploadedImg']['tmp_name'], $imageUrl)) {
				echo "<p>The image ".basename( $_FILES['uploadedImg']['name']). 
					" has been uploaded.</p>";
				$newItem = new Style($_REQUEST["itemName"], $_REQUEST["itemSeason"], $_REQUEST["itemPrice"], $_REQUEST["inStock"], $imageUrl);
				if ($_SESSION["database"]->addToDB($newItem)) {
					$_SESSION["style"][count($_SESSION["style"])] = $newItem;
			}
			} else{
				echo "<p>There was an error uploading your image, please try again.</p>";
			}


		} else if ( isset($_REQUEST["changeItem"]) ) {
			
			$imageUrl;

			if ( basename($_FILES["uploadedImg"]["name"]) != "" ) {
				$imageUrl = "Images/Lookbook/";
				$imageUrl .= basename($_FILES["uploadedImg"]["name"]);

				if(move_uploaded_file($_FILES['uploadedImg']['tmp_name'], $imageUrl)) {
					echo "<p>The image ".basename( $_FILES['uploadedImg']['name']). 
						" has been uploaded.</p>";
				} else{
					echo "<p>There was an error uploading your image, please try again.</p>";
				}
			} else {
				$imageUrl = $_SESSION["style"][$_REQUEST["styleKey"]]->getImage();
			}

			$style = $_SESSION["style"][$_REQUEST["styleKey"]];
			$style->setName($_REQUEST["itemName"]);
			$style->setSeason($_REQUEST["itemSeason"]);
			$style->setPrice($_REQUEST["itemPrice"]);
			$style->setStock($_REQUEST["inStock"]);
			$style->setImage($imageUrl);

			if($_SESSION["database"]->updateDB($_REQUEST["itemName"],$_REQUEST["itemSeason"],$_REQUEST["itemPrice"],$_REQUEST["inStock"],$imageUrl)) {
				$_SESSION["style"][$_REQUEST["styleKey"]] = $style;
			} else {
				?><p>The item could not be updated. Please try again.</p><?php
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


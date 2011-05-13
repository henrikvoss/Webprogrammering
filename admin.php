<?php include('controller.php') ?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />

	<meta name="description" content="Shop at VATLE." />

	<title>VATLE - Webshop</title>

	<?php addLinkTags(); ?>
</head>

<body>
	<?php	printHeader(); ?>
	<section class="text">
		
<?php 

	if( isset($_SESSION["user"]) ) 
	{
		if( $_SESSION["user"]->getIfAdmin() )
	}
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

	else if ( isset($_REQUEST["changeItem"]) ) {

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
		} 
		else 
		
		{
			?><p>The item could not be updated. Please try again.</p>
		<?php
		}
	}

	} 
	else 
	{
		?><a href="index.php">Go to shop</a>
<?php
	}
} /* END if( isset(session[user]) ) */
else 
	{
?>

		<a href="index.php">Go to shop</a>

<?php
	}
?>

	</section>
<?php printFooter(); ?>

</body>
</html>
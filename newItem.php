<?php include("controller.php"); ?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />
	<title>
		VATLE - Webshop - Add a new item
	</title>
	<?php addLinkTags(); ?>
</head>

<body>
	<?php	printHeader(); ?>
	<section class="text">

<?php
if ( isset($_SESSION["user"]) ) {
	if ( $_SESSION["user"]->getIfAdmin() ) {
?>

<h1>Add a new item</h1>

<form enctype="multipart/form-data" action="newItem.php" method="post">
	<table border="0" cellspacing="5" cellpadding="5">
		<tr>
			<td>Item name:</td>
			<td><input type="text" name="itemName"></td>
			<td>Season:</td>
			<td><input type="text" name="itemSeason"></td>
		</tr>
		<tr>
			<td>Price:</td>
			<td><input type="text" name="itemPrice"></td>
			<td>In Stock:</td>
			<td><input type="text" name="inStock"></td>
		</tr>
		<tr>
			<td><input type="hidden" name="MAX_FILE_SIZE" value="1000000">
		</tr>
	</table>
	<table>
		<tr>
			<td>Choose a file to upload:<input name="uloadedImg" type="file"><input type="submit" name="addItem" value="Upload Item"></td>
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


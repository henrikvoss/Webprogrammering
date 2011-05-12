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
	<p>
		Item name:
		<input type="text" name="itemName" />
		Season:
		<input type="text" name="itemSeason" />
		Price:
		<input type="text" name="itemPrice" />
		In stock:
		<input type="text" name="inStock" />
	</p>
	<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
	<p>
		Choose a file to upload: <input name="uploadedImg" type="file" />
	</p>
	<p>
		<input type="submit" name="addItem" value="Upload Item" />
	</p>
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


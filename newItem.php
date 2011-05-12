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
				<td>Choose a file to upload:<input name="uploadedImg" type="file">
					<input type="submit" name="addItem" value="Upload Item">
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
		<img class="floatLeft" src="<?php echo $changeStyle->getImage(); ?>"
	alt="<?php echo $changeStyle->getName(); ?>"/>
	<input type="text" name="imageUrl" value="<?php echo $changeStyle->getImage(); ?>" />
		<table>
			<tr>
				<td>Upload a new file:<input name="uploadedImg" type="file">
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
			} else{
				echo "<p>There was an error uploading your image, please try again.</p>";
			}

			$newItem = new Style($_REQUEST["itemName"], $_REQUEST["itemSeason"], $_REQUEST["itemPrice"], $_REQUEST["inStock"], $imageUrl);
			if ($_SESSION["database"]->addToDB($newItem)) {
				$_SESSION["style"][count($_SESSION["style"])] = $newItem;
			}

		} else if ( isset($_REQUEST["changeItem"]) ) {
			
			$imageUrl;

			if (isset($_REQUEST["uploadedImg"])) {
				$imageUrl = "Images/Lookbook/";
				$imageUrl .= basename($_FILES["uploadedImg"]["name"]);

				if(move_uploaded_file($_FILES['uploadedImg']['tmp_name'], $imageUrl)) {
					echo "<p>The image ".basename( $_FILES['uploadedImg']['name']). 
						" has been uploaded.</p>";
				} else{
					echo "<p>There was an error uploading your image, please try again.</p>";
				}
			} else {
				$imageUrl = $_REQUEST["imageUrl"];
			}

			$style = $_SESSION["style"][$_REQUEST["styleKey"]];
			$style->setName($_REQUEST["itemName"]);
			$style->setSeason($_REQUEST["itemSeason"]);
			$style->setPrice($_REQUEST["itemPrice"]);
			$style->setStock($_REQUEST["inStock"]);
			$style->setImage($imageUrl);
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


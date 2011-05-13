<?php
include("controller.php");

function printCart($cart) {
	foreach ($cart as $key=>$style) {?>
	<div class="browseStyles">

		<img class="floatLeft" src="<?php echo $style->getImage(); ?>"
		alt="<?php echo $style->getName(); ?>"/>
		<p>Style: <?php echo $style->getName(); ?></p>
		<p>Price: <?php echo $style->getPrice(); ?></p>
		<p>You have <?php echo $style->getAmountInCart(); ?> in your cart.</p>
		<!-- En form for å slette og endre antall. -->
		<form action="cart.php" method="post">
			<input type="hidden" name="cartKey" value="<?php echo $key ?>" />
			<input type="text" name="newAmount" value="<?php echo $style->getAmountInCart(); ?>" />
			<input type="submit" name="updateItem" value="Change amount" />
			<input type="submit" name="deleteItem" value="Delete this item" />
		</form>

		</div><?php
	}
}

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />

	<title>
		VATLE - Webshop - Shopping-cart
	</title>

	<?php addLinkTags(); ?>
</head>

<body>
	<?php printHeader(); ?>
	<section class="text">

<?php
if (!isset($_SESSION["user"])) {
	?><a href="index.php">Go to shop</a><?php
} else {
?>

<h1>Your cart</h1>

<?php

	$itemInStock = array();

	if ( isset($_REQUEST["addToCart"]) ) {

		if ( !isset($_SESSION["cart"]) ) {
			$_SESSION["cart"] = new Cart();
		}

		for ( $i = 0; $i < count($_SESSION["style"]); $i++ ) {
			if (isset($_REQUEST[("amount".$i)])){
				if ( $_REQUEST[("amount".$i)] != 0) {
					$itemInStock[$i] = $_SESSION["cart"]->addToCart($i,$_REQUEST[("amount".$i)]);
				}
			}
		}

		foreach ($itemInStock as $key=>$value) {
			if ( !$value ) {	
				?><p>Item <?php echo $_SESSION["style"][$key]->getName(); ?> is out of stock.</p><?php
			} else {
				?><p><?php echo $value." of item ".$_SESSION["style"][$key]->getName(); ?> is available.</p><?php
			}
		}
	}

	if ( isset($_REQUEST["deleteItem"]) ) {
		$_SESSION["cart"]->deleteItem($_REQUEST["cartKey"]);
	}

	printCart($_SESSION["cart"]->getCart());
}
?>

	</section>
	<?php printFooter(); ?>
</body>

</html>


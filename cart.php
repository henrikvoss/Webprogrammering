<?php
include("controller.php");

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
}

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
		<h1>Your cart</h1>

<?php

if ( isset($_REQUEST["addToCart"]) ) {
	foreach ($itemInStock as $key=>$value) {
		if ( !$value ) {	
			?><p><?php echo $_SESSION["style"]->getName(); ?> is out of stock.</p><?php
		} else {
			?><p><?php echo $value." ".$_SESSION["style"]->getName(); ?> is available.</p><?php
		}
	}
	?></p><?php
}

?>

<?php printCart($_SESSION["cart"]->getCart()); ?>

	</section>
	<?php printFooter(); ?>
</body>

</html>


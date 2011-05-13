<?php
include("controller.php");

$itemInStock = false;

if ( isset($_REQUEST["addToCart"]) ) {

	if ( !isset($_SESSION["cart"]) ) {
		$_SESSION["cart"] = new Cart();
	}

	for ( $i = 0; $i < count($_SESSION["style"]); $i++ ) {
		if ( $_REQUEST[("amount".$i)] != 0) { /* Noen av de reqested kan være NULL, vil det funke da? */
			if($_SESSION["cart"]->addToCart($i,$_REQUEST[("amount".$i)])) {
				$itemInStock = true;
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
			<p>You have <?php echo $style->getAmountInCart(); ?> in you cart.</p>
			<!-- Her en form for å slette og endre antall. -->

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
	?><p><?php
	if ( $itemInStock ) {
		?>The new item was added to your cart.<?php
	} else {
		?>The item you requested is out of stock.<?php
	}
	?>Return to <a href="<?php echo $_REQUEST["searchPage"]; ?>">your search</a>.</p><?php
}

?>

<?php printCart($_SESSION["cart"]->getCart()); ?>

	</section>
	<?php printFooter(); ?>
</body>

</html>


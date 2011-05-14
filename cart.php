<?php
include("controller.php");

function printCart($cart) {
	$total = 0;
	foreach ($cart as $key=>$quantity) {
		$style = $_SESSION["style"][$key];
?>
		<div class="browseStyles">

			<img class="floatLeft" src="<?php echo $style->getImage(); ?>"
			alt="<?php echo $style->getName(); ?>"/>
			<p>Style: <?php echo $style->getName(); ?></p>
			<p>Price: <?php echo $style->getPrice(); ?></p>
			<p>You have <?php echo $style->getAmountInCart(); ?> in your cart.</p>

			<!-- En form for å slette og endre antall. -->
			<?php if (!isset($_REQUEST["acceptDelivery"])) { ?>
				<form action="cart.php" method="post">
					<input type="hidden" name="cartKey" value="<?php echo $key ?>" />
					<input type="text" name="newAmount" value="<?php echo $quantity; ?>" />
					<input type="submit" name="updateItem" value="Change quantity" />
					<input type="submit" name="deleteItem" value="Delete this item" />
				</form>
			<?php } ?>

			<p>Sum: <?php echo ($style->getPrice() * $quantity); ?></p>

		</div><?php
		$total += ($style->getPrice() * $quantity);
	}
	?>

	<form action="cart.php" method="post">

		<?php if (!isset($_REQUEST["acceptDelivery"])) { ?>
			<p>Total: <?php echo $total; ?> NOK</p>
			<!-- Here checkboxes with different delivery types. -->
			<?php if ($total > 0) { ?>
			<p>
				<input type="radio" name="delivery" checked="checked" value="regular" /> Regular delivery 50 NOK
			</p>
			<p>
				<input type="radio" name="delivery" value="express" /> Express delivery 100 NOK
			</p>
			<p>
				<input type="submit" name="acceptDelivery" value="Accept delivery type" />
			</p>
			<?php } ?>
<?php
		} else {
			if ( $_REQUEST["delivery"] == "regular" ) { ?>
				<p>Total with regular delivery: <?php echo ($total + 50); ?> NOK</p>
			<?php } else { ?>
				<p>Total with express delivery: <?php echo ($total + 100); ?> NOK</p>
			<?php	} ?>
			<form action="cart.php" method="post">
				<input type="submit" name="submitOrder" value="Submit your order" />
			</form>
			<a href="cart.php">or go back</a>
		<?php } ?>
	</form>
<?php
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
	if (isset($_REQUEST["submitOrder"])) {

		$_SESSION["cart"]->submitOrder();
		?><p>Your order was submitted.</p><?php

	} else {

		$itemInStock = array();

		if ( isset($_REQUEST["addToCart"]) ) {

			if ( !isset($_SESSION["cart"]) ) {
				$_SESSION["cart"] = new Cart();
			}

			for ( $i = 0; $i < count($_SESSION["style"]); $i++ ) {
				if (isset($_REQUEST[("amount".$i)])){
					if ( $_REQUEST[("amount".$i)] > 0) {
						$itemInStock[$i] = $_SESSION["cart"]->addToCart($i,$_REQUEST[("amount".$i)]);
					}
				}
			}

			foreach ($itemInStock as $key=>$value) {
				if ( $value == 0 ) {	
					?><p>Item <?php echo $_SESSION["style"][$key]->getName(); ?> was out of stock.</p><?php
				} else {
					?><p><?php echo $value." of item ".$_SESSION["style"][$key]->getName(); ?> was available.</p><?php
				}
			}
		}

		if ( isset($_REQUEST["deleteItem"]) ) {
			$_SESSION["cart"]->deleteItem($_REQUEST["cartKey"]);

		} else if ( isset($_REQUEST["updateItem"]) ) {

			/* UPDATE ITEM IN HERE: */
			$key = $_REQUEST["cartKey"];
			$value;
			if ($_REQUEST["newAmount"] < $_SESSION["cart"]->getAmount($key)){
				$value = $_SESSION["cart"]->updateInCart($key, ($_REQUEST["newAmount"] - $_SESSION["cart"]->getAmount($key)));
			} else {
				$value = $_SESSION["cart"]->updateInCart($key, $_REQUEST["newAmount"]);
			}
			if ($value == 0) {
				?><p>No more of item <?php echo $_SESSION["style"][$key]->getName(); ?> on stock.</p><?php
			} else if ( $value > 0 ) {
				?><p><?php echo $value." of item ".$_SESSION["style"][$key]->getName(); ?> was available.</p><?php
			}
		}

		printCart($_SESSION["cart"]->getCart());
	}
}
?>

	</section>
	<?php printFooter(); ?>
</body>

</html>


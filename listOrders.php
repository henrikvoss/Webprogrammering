<?php include('controller.php'); ?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />
	<title>
		VATLE - Webshop - Admin
	</title>
	<?php addLinkTags(); ?>
</head>

<body>
	<?php printHeader(); ?>
	<section class="text">

<?php if (!isset($_SESSION["user"])) { /* Er ikke pålogget: */ ?>
	<a href="index.php">Please login</a>

<?php } else if (!$_SESSION["user"]->getIfAdmin()) { /* Er ikke admin: */ ?>
	<a href="index.php">Return to shop</a>

<?php
} else { /* Er både pålogget og admin: */

	if ( isset($_REQUEST["deleteOrder"]) ) {
		$sql = "delete from History where orderno = ".$_REQUEST['orderno']." and stylename = '".$_REQUEST['stylename']."'";
		$_SESSION['database']->delete($sql);
	}

	$orders = $_SESSION["database"]->getOrdersTable();

?>

	<h1>List and update orders</h1>

	<?php	if ( !$orders ) { ?>
		<p>There are no previous orders.</p>

<?php
	} else {

		foreach ($orders as $key=>$order) {
?>
			<p>
				<?php echo $order->date; ?>
				Orderno: <?php echo $order->orderno; ?>.
				Customer: <?php echo $order->email; ?> has ordered
				<?php echo $order->amount; ?> of
				item &quot;<?php echo $order->stylename; ?>&quot;

				<form action="listOrders.php" method="post">
					<input type="hidden" name="orderno"
						value="<?php echo $order->orderno; ?>" />
					<input type="hidden" name="stylename"
						value="<?php echo $order->stylename; ?>" />
					<input type="submit" name="deleteOrder" value="Delete order line" />
				</form>
			</p>
<?php
		}
	}
}
?>

	</section>
	<?php printFooter(); ?>
</body>

</html>


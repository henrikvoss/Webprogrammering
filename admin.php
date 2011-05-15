<?php
include('controller.php');

function printStyle($style, $styleArrayKey) { ?>
	<div class="browseStyles">

		<img class="floatLeft" src="<?php echo $style->getImage(); ?>"
		alt="<?php echo $style->getName(); ?>"/>
		<p>Style: <?php echo $style->getName(); ?></p>
		<p>Price: <?php echo $style->getPrice(); ?></p>
		<p>Stock: <?php echo $style->getStock(); ?></p>
		<form action="newItem.php" method="post">
			<input type="submit" name="<?php echo $style->getSessionKey(); ?>" value="Update item"/>
		</form>
	</div>
<?php } ?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />

	<title>VATLE - Webshop - Admin</title>

	<?php addLinkTags(); ?>
</head>

<body>
	<?php	printHeader(); ?>
	<section class="text">

<?php if (!isset($_SESSION["user"])) { /* Er ikke pålogget: */ ?>
	<a href="index.php">Please login</a>

<?php } else if (!$_SESSION["user"]->getIfAdmin()) { /* Er ikke admin: */ ?>
	<a href="index.php">Return to shop</a>

<?php
} else { /* Er både pålogget og admin: */

	$seasons = $_SESSION["database"]->getAllSeasons();
?>

	<h1>Admin Page</h1>
	<ul>
		<li><a href="newItem.php">Add a new item to the database</a></li>
		<li><a href="listOrders.php">List and edit orders</a></li>
	</ul>

	<h2>Browse and update items</h2>
	<p class="info">To view all styles and prices on our merchandise, leave the dropdown menus blank, and click "Show".</p>

	<form id="request" action="admin.php" method="get" >
		<table border="0" >
			<tr>
				<td>Choose style:</td>
				<td align="right">
					<select name="season">
						<option value="none">--Choose a season</option>

						<?php	foreach ($seasons as $key=>$name) { ?>
							<option value="<?php echo $name ?>"><?php echo $name; ?></option>
						<?php } ?>

					</select>
				</td>

				<td>Price range:</td>
				<td align="right">
					<select name="price">
						<option value="none">--Choose price range</option>
						<option value="low">Low (0-&gt;1499)</option>
						<option value="medium">Medium (1500-&gt;2999)</option>
						<option value="high">High (3000-&gt;)</option>
					</select>
				</td>

				<td>Show wares:</td>
				<td><input type="submit" name="listStyles" VALUE="Show"></td>
			</tr>
		</table>
	</form>

<?php
	if ( isset($_REQUEST["listStyles"]) ) {
		$gtPrice = 0;
		$ltPrice = 999999;

		if ( $_REQUEST["price"] != "none" ) {
			if ( $_REQUEST["price"] == "low" ) {
				$ltPrice = 1499;
			} else if ( $_REQUEST["price"] == "medium" ) {
				$gtPrice = 1500;
				$ltPrice = 2999;
			} else {
				$gtPrice = 3000;
			}
		}

		if (($_REQUEST["season"] != "none") && ($_REQUEST["price"] != "none")) {
			?><h2>Styles in <?php echo $_REQUEST["season"]; ?>
			with <?php echo $_REQUEST["price"]; ?> price</h2><?php

				/* Liste varer som oppfyller begge kriterier: */
				foreach ($_SESSION["style"] as $key=>$style) {
					if ( ($style->getSeason() == $_REQUEST["season"]) && (($gtPrice <= $style->getPrice()) && ($style->getPrice() <= $ltPrice)) ) {
						printStyle($style,$key);
					}
				}

		} elseif ( ($_REQUEST["season"] != "none") && ($_REQUEST["price"] == "none") ) {
			?><h2>Styles in <?php echo $_REQUEST["season"]; ?></h2><?php

			/* Liste aller varer for en sesong: */
			foreach ($_SESSION["style"] as $key=>$style) {

				if ( ($style->getSeason() == $_REQUEST["season"]) ) {
					printStyle($style,$key);
				}
			}

		} elseif ( ($_REQUEST["season"] == "none") && ($_REQUEST["price"] != "none") ) {
			?><h2>Styles with <?php echo $_REQUEST["price"]; ?> price</h2><?php

			/* Liste aller varer for en priskategori: */
			foreach ($_SESSION["style"] as $key=>$style) {

				if ( (($gtPrice <= $style->getPrice()) && ($style->getPrice() <= $ltPrice)) ) {
					printStyle($style,$key);
				}
			}

		} else {
			?><h2>All styles</h2><?php

			/* Liste alle varer: */
			foreach ($_SESSION["style"] as $key=>$style) {
				printStyle($style,$key);
			}
		}
	}
}

?>

	</section><!-- End text class section. -->
	<?php printFooter(); ?>
</body>
</html>

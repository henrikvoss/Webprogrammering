<?php
include('controller.php');

function printStyle($style, $styleArrayKey) {
?>

	<div class="browseStyles">

		<img class="floatLeft" src="<?php echo $style->getImage(); ?>"
		alt="<?php echo $style->getName(); ?>"/>
		<p>Style: <?php echo $style->getName(); ?></p>
		<p>Price: <?php echo $style->getPrice(); ?></p>
		<p>Stock: <?php echo $style->getStock(); ?></p>
		<?php if ($style->getStock() > 0) {?>
			<p>
				Add to cart:
				<input type="text" name="amount<?php echo $style->getSessionKey(); ?>" value="0" />
			</p>
		<?php } else { ?>
		<p>None left in stock.</p>
		<?php } ?>
	</div>

<?php
}	
?>

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

if (isset($_REQUEST["login"])) {

	if ( $_SESSION["database"]->checkUser($_REQUEST["username"],$_REQUEST["password"]) ) {
		setUser($_REQUEST["username"]);
		/* så sjekker controller.php:
		 * Sjekker om bruker er admin i classCustomer-konstruktøren.  
		 **/
	}

} else if(isset($_REQUEST["addNewUser"]))	{
	$_SESSION['database']->addUserData($_POST['email'],$_POST['password'], $_POST['first'], $_POST['surname'], $_POST['address'], $_POST['postalcode'], $_POST['city'], $_POST['country']);
	setUser($_REQUEST["email"]);
}



if (!isset($_SESSION["user"])) {
?>

	<h1>Login</h1>

	<form id="login" action="index.php" method="post">
		<table border="0" cellspacing="5" cellpadding="5">
			<tr>
				<td>Email:</td>
				<td><input type = "text" name = "username" size = 40></td>
			</tr>
			<tr>
				<td>Password:</td>
				<td><input type = "password" name = "password" size = 40></td>
			</tr>
			<tr>
				<td><input type = "submit" name = "login" value = "Login"/></td>
			</tr>
		</table>
	</form>

	<p class="floatRight"><a href="register.php">Not registered?</a></p>

<?php
} else {

	$seasons = $_SESSION["database"]->getAllSeasons();

	/* Dashboard to browse and update items -------------------------------*/
	?><h1>Browse items</h1>

	<?php	if ( $_SESSION["user"]->getIfAdmin() ) { ?>
		<ul>
			<li><a href="admin.php">Go to admin page</a></li>
		</ul>
	<?php	} else { ?>
		<p>
			To view all styles and prices on our merchandise, leave the dropdown menus on default, and click "Show".
		</p>
<?php } ?>

<form id="request" action="index.php" method="get" >
	<table border="0" >
		<tr>
			<td>Choose style:</td>
			<td align="right">
				<select name="season">
					<option value="none">--Choose a season</option>

					<?php	foreach ($seasons as $name) { ?>
						<option value="<?php echo $name; ?>"><?php echo $name; ?></option>
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
			<td><input type="submit" name="listStyles" value="Show"></td>
		</tr>
	</table>
</form>

<form action="cart.php" method="post">
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
			with <?php echo $_REQUEST["price"]; ?> price</h2>
<div class="clearBoth">
<input type="submit" name="addToCart" value="Add chosen items to cart" />
</div>

<?php

				/* Liste varer som oppfyller begge kriterier: */
				foreach ($_SESSION["style"] as $key=>$style) {
					if ( ($style->getSeason() == $_REQUEST["season"]) && (($gtPrice <= $style->getPrice()) && ($style->getPrice() <= $ltPrice)) ) {
						printStyle($style,$key);
					}
				}

		} elseif ( ($_REQUEST["season"] != "none") && ($_REQUEST["price"] == "none") ) {
			?><h2>Styles in <?php echo $_REQUEST["season"]; ?></h2>
<div class="clearBoth">
<input type="submit" name="addToCart" value="Add chosen items to cart" />
</div>

<?php

			/* Liste aller varer for en sesong: */
			foreach ($_SESSION["style"] as $key=>$style) {

				if ( ($style->getSeason() == $_REQUEST["season"]) ) {
					printStyle($style,$key);
				}
			}

		} elseif ( ($_REQUEST["season"] == "none") && ($_REQUEST["price"] != "none") ) {
			?><h2>Styles with <?php echo $_REQUEST["price"]; ?> price</h2>
<div class="clearBoth">
<input type="submit" name="addToCart" value="Add chosen items to cart" />
</div>

<?php

			/* Liste aller varer for en priskategori: */
			foreach ($_SESSION["style"] as $key=>$style) {

				if ( (($gtPrice <= $style->getPrice()) && ($style->getPrice() <= $ltPrice)) ) {
					printStyle($style,$key);
				}
			}

		} else {
?>
			<h2>All styles</h2>
			<div class="clearBoth">
			<input type="submit" name="addToCart" value="Add chosen items to cart" />
			</div>

<?php

			/* Liste alle varer: */
			foreach ($_SESSION["style"] as $key=>$style) {
				printStyle($style,$key);
			}
		}

?>

	<div class="clearBoth">
	<input type="submit" name="addToCart" value="Add chosen items to cart" />
	</div>
</form>

<?php
	}
	/* END Dashboard to browse and update items ---------------------------*/

}
?>

</section><!-- End text class -->
<?php printFooter(); ?>

</body>
</html>

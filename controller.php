<?php

/*
TODO:
create basket.php
create admin.php
TODO:
oppdatere tabell Style til å ha en primærnøkkel som ikke er navnet på plagget
TODO:
En metode eller annen måte som sjekker for SQL-planting!
input må ikke inneholde semikolon, erlik-tegn, sql-kommentar-tegn,
visse sql-syntax-ord. Se uke 13 i webprog-fagstoff!
 */

session_start();
/*
error_reporting(0);
For bruk under utvikling:
 */
error_reporting(-1);

/* Sikrer at database-objektet er klart. */
if (!isset($_SESSION["database"])) {
	$_SESSION["database"] =
		new Database('cube.iu.hio.no', 's171172', '', 's171172');
}

/* Sjekker om vareobjekter er opprettet, hvis ikke:
 * -Henter alle varene fra databasen og oppretter objekter for hver vare.
 * -Alle varene er i en array i $_SESSION["styles"]. */
if ( !isset($_SESSION["style"]) ) {
	$sql = "select * from Style";
	$styleTable = $_SESSION["database"]->selectQuery($sql);
	$allStylesArray = array();

	for ( $i = 0; $i < count($styleTable); $i++ ) {
		$allStylesArray[$i] =
			new Style($styleTable[$i]->stylename, $styleTable[$i]->season, $styleTable[$i]->pricePerStyle, $styleTable[$i]->stock, $styleTable[$i]->image);
	}

	$_SESSION["style"] = $allStylesArray;
}

function __autoload($className) {
	include_once("class".$className.".php");
}

/*
 * Sjekker om bruker er admin i classCustomer-konstruktøren.  
 * controller.php henter alle
 * data fra databasen for å opprette kunde-objektet.
 *
 * Husk: denne metoden sjekker ikke om kundenavn eller passord stemmer, det 
 * må være gjort på forhånd med checkUser-metoden i Database-klassen.
 **/
function setUser($name) {
	$_SESSION["user"] = new User($name);
}

/* TODO:
 * Lage mulighet til å legge til handlekurven og for admin og endre vare.
 */
function printStyle($style, $styleArrayKey) {?>
<div class="browseStyles">

	<img class="floatLeft" src="<?php echo $style->getImage(); ?>"
	alt="<?php echo $style->getName(); ?>"/>
	<p>Style: <?php echo $style->getName(); ?></p>
	<p>Price: <?php echo $style->getPrice(); ?></p>
	<p>Stock: <?php echo $style->getStock(); ?></p>
	<?php if ($style->getStock() != 0) {?>
	<form action="basket.php" method="post">
		<input type="text" name="amount<?php echo $styleArrayKey; ?>" value="1" />
		<input type="submit" name="<?php echo $styleArrayKey; ?>" value="Add to basket" />
	</form>
	<?php }?>
	<?php if ( $_SESSION["user"]->getIfAdmin() ) { ?>
	<form action="newItem.php" method="post">
		<input type="submit" name="<?php echo $styleArrayKey; ?>" value="Change item"/>
	</form>
	<?php	} /* END ifAdmin */ ?>
</div>
<?php
}	

/* Methods that print out html-structure-code (eg. footer, header): */

function addLinkTags() {?>
	<link rel="stylesheet" type="text/css" href="vatle.css" title="Normal style" /><?php
}

function printHeader() { ?>
<section id="wrap">
	<header id="logoAndMainMenu">

		<a title="VATLE home" href="index.php">
			<img src="Images/vatle.gif" alt="VATLE HOME"
			height="45" width="183" />
		</a>

		<nav id="mainMenu">
			<section class="floatLeft">
				<a href="news.php" class="news" title="News on VATLE">
					NEWS
					<span></span>
				</a>
				<a href="collections.php" class="collections" title="Collections by VATLE">
					COLLECTIONS
					<span></span> 
				</a>
				<a href="index.php" class="shop" title="Shop VATLE">
					SHOP
					<span></span>
				</a>
			</section>

			<section class="floatRight">
				<a href="news.php" class="press" title="The press on VATLE">
					PRESS
					<span></span>
				</a>
				<a href="news.php" class="contact" title="Contact VATLE">
					CONTACT
					<span></span>
				</a>
				<a href="news.php" class="about" title="About VATLE">
					ABOUT
					<span></span>
				</a> 
			</section>
		</nav>

		</header> <?php
}

function printFooter() { ?>
<div id="footerPush"></section>
	</section>


	<footer>
		<section class="floatRight">
			<span class="followVatle">Follow VATLE:</span>
			<a href="http://vatlelate.blogspot.com/" class="blog" title="VATLE blog">
				-Blog<span></span>
			</a>
			<a href="http://www.facebook.com/pages/VATLE/123522228489" class="facebook" title="VATLE on facebook">
				-Facebook<span></span>
			</a>
			<a href="http://twitter.com/#!/vatle" class="twitter" title="VATLE on twitter">
				-Twitter<span></span>
			</a>
		</section>

<?php

	if (isset($_SESSION["user"])) {?>
	<section class="floatLeft">
		<a href="logout.php">Logout</a>
		|
		<a href="basket.php">Basket</a>
		<?php if ($_SESSION["user"]->getIfAdmin()) { ?>
		| You are logged in as admin. See
		<a href="admin.php">admin page</a>.
		<?php } ?>
		</section><?php
	} else {?>
	<section class="floatLeft">
		<a href="index.php">Login</a>
		</section><?php
	}?>

	</footer> <?php
}

function printUnderConstruction() {?>
<h1 class="center">This part of the site is currently under construction 
and will be up	soon. Please check back later.</h1><?php
}

?>

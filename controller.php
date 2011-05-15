<?php

/*
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
set_error_handler('writeError', E_ALL);
register_shutdown_function('shutdownError');


/* Sikrer at database-objektet er klart. */
if (!isset($_SESSION["database"])) {
	$_SESSION["database"] =
		new Database('cube.iu.hio.no', 's171172', '', 's171172');
}

/* Sjekker om vareobjekter er opprettet, hvis ikke:
 * -Henter alle varene fra databasen og oppretter objekter for hver vare.
 * -Alle varene er i en array i $_SESSION["styles"].
 * 
 * TODO: må han en sjekk hver gang bruker retunerer til denne siden som 
 * sjekker om det er lagt til nye varer i databasen å legger de til i 
 * arrayen.
 */
if ( !isset($_SESSION["style"]) ) {
	$sql = "select * from Style";
	$styleTable = $_SESSION["database"]->selectQuery($sql);
	$allStylesArray = array();

	for ( $i = 0; $i < count($styleTable); $i++ ) {
		$allStylesArray[$i] =
			new Style($styleTable[$i]->stylename, $styleTable[$i]->season, $styleTable[$i]->pricePerStyle, $styleTable[$i]->stock, $styleTable[$i]->image, $i);
	}

	$_SESSION["style"] = $allStylesArray;
} else if ( $_SESSION['database']->getNumberOfItems() > count($_SESSION['style']) ) {
	/* Det er lagt til en ny vare som må legges til i $_SESSION['style']: */
	$newItems = $_SESSION['database']->selectQuery("select * from Style");

	for ( $i = count($_SESSION['style']); $i < count($newItems); $i++ ) {
		$_SESSION['style'][$i] = new Style($newItems[$i]->stylename, $newItems[$i]->season, $newItems[$i]->pricePerStyle, $newItems[$i]->stock, $newItems[$i]->image);
	}
}

function __autoload($className) {
	include_once("class".$className.".php");
}

function shutdownError() {
	$feil = error_get_last(); /* returnerer en array */
	skrivFeil($feil['type'], $feil['message'], $feil['file'], $feil['line']);
}

function writeError($feilnr, $feilmelding, $feilfil, $linjenr)	{
	$dato = date('d-m-Y H:i');
	$melding = $dato."\n";
	$melding += $feilnr.": ".$feilmelding." i fil '".$feilfil."' paa linje ".$linjenr."\n\n";
	error_log($melding, 3, './.phpfeil.log');
	/* '3' for å skrive til en valgt fil. */
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

		<?php	if (isset($_SESSION["user"])) { ?>
			<section class="floatLeft">
				<a href="logout.php">Logout</a>
				|
				<a href="cart.php">Cart</a>
				<?php if ($_SESSION["user"]->getIfAdmin()) { ?>
				| You are logged in as admin. See
				<a href="admin.php">admin page</a>.
				<?php } ?>
				</section>
		<?php	} else { ?>
			<section class="floatLeft">
				<a href="index.php">Login</a>
			</section>
		<?php	} ?>

	</footer>

<?php
}

function printUnderConstruction() {
?>
	<p>
		Vi startet med å basere siden vår på et design som Johan Steinberg
		utvikler for <a href="http://www.vatledesigns.com">VATLE</a>, derfor
		er menylinjen egentlig bare til pynt i denne prosjektoppgave med
		ikke funksjonelle lenker.
	</p>
<?php
}
?>

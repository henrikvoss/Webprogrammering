<?php include('controller.php'); ?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />

	<meta name="description" content="Contact VATLE." />

	<meta name="keywords" content="contact, Vatle,
	clothing, women&#39;s clothing, soon men&#39;s clothing, designer clothing, Vatle
	designs" />

	<title>VATLE - Shop</title>

	<?php addLinkTags(); ?>
</head>

<body>
	<?php	printHeader(); ?>
	<section class="text">
		<h1>Kjersti Vatle Toresen</h1>
		<h2>About</h2>
		<p>Kjersti Vatle Toresen is the founder and head designer of VATLE.</p>
		<p>Kjersti was born and raised in Stavanger / Mandal. At the age of 20 she finished her advanced craft certificate in tailoring and moved to Herning in Denmark to attend TEKO Center Denmark The Acadamy of Design & Textile. She graduated as the best student in 2003. She got top-grade for her graduation collection and was offered design positions from different labels. In spite of this she decided to go back to Norway and enter the norwegian fashion scene. She began working as a freelance designer. Among other jobs she worked with technical clothing for the norwegian snowboard brand Whiteout, owned by Norrøna. In 2007 her collection was voted "Best newcomer" from the famous international magazine "Sports Illustrated". She was nominated in the same category as Alexander McQueen.</p>
		<p>Kjersti founded VATLE in 2008, and currently resides in Oslo. VATLE's design studio is also located here. VATLE is at the moment working towards production.</p>
		<h2>Contact VATLE by email below</h2>
		<form action="contact.php" method="post">
			<p>
			Name:<br />
			<input class="textline" type="text" name="name" />
			</p>
			<p>
			Email:<br />
			<input class="textline" type="text" name="email" />
			</p>
			<p>
			Message:<br />
			<textarea class="textbox" name="message"></textarea>
			</p>
			<p><input type="submit" name="submit" value="Submit" /></p>
		</form>

<?php
if (isset($_POST["submit"])) {
	/* Send mail til Kjersti med all info og skriv ut beskjed til bruker. */
	if (mail("s171172@stud.hio.no", ("Henvendelse fra ".$_POST["name"]." fra hjemmesiden."), $_POST["message"]."\n--\nNavn: ".$_POST["name"]."\nEmail: ".$_POST["email"]." (svar kunden på denne adressen)")) {?>
		<p>Your request has been sent.</p><?php
	}
	else {?>
		<p>
		<em>Your request could not be sent because of an error!</em>
		</p><?php
	}
}
?>

	</section>
	<?php printFooter();	?>
</body>

</html>


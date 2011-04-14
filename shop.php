<?php include('controller.php'); ?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />

	<meta name="description" content="Contact VATLE." />

	<meta name="keywords" content="contact, Vatle,
	clothing, women&#39;s clothing, soon men&#39;s clothing, designer clothing, Vatle
	designs" />

	<title>VATLE - Contact</title>

	<?php addLinkTags(); ?>
</head>

<body>
	<?php	printHeader(); ?>
	<section class="text">
		<h1>Stores</h1>
		
		<form id="login" action="login.php" method="post">
			<p>Username:
				<input type = "text" name = "username" size = 30>
			</p>
			
			<p>Password:
				<input type = "password" name = "password" size = 15>
			</p>
			
			<p>
				<input type = "submit" value = "login"/>
			</p>
			
		</form>
		
		<p>
			<em>
			FLASHDANCE
			</em>
			<br />
			Posthallen, Kvadraturen<br />
			Oslo, Norway
		</p>
	</section>
	<?php printFooter();	?>
</body>

</html>


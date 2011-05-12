<?php include('controller.php') ?>
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
		<?php if ( $_SESSION["user"]->getIfAdmin() ) ?>
	</section>

<?php printFooter(); ?>

</body>
</html>
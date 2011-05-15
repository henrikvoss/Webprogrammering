<?php include("controller.php"); ?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />

	<title>
		VATLE - Logout
	</title>

	<?php addLinkTags(); ?>
</head>

<body>
	<?php	printHeader(); ?>
	<section class="text">
		<?php unset($_SESSION["user"]); ?>
		<a href="index.php">Login</a>
	</section><!-- End text class -->
	<?php printFooter(); ?>
</body>

</html>


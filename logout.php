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
	</section><!-- End text class -->
	<?php printFooter(); ?>
</body>

</html>


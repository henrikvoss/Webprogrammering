<?php
include("controller.php");
include("lookbook.php");
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />

	<meta name="description" content="MJ S/S 2010 collection by the Norwegian clothing brand VATLE." />

	<meta name="keywords" content="MJ, S/S 2010, Vatle,
	collection, clothing, women&#39;s clothing, designer" />

	<title>
		VATLE - &quot;MJ&quot; S/S 2010
	</title>

	<?php addLinkTags(); ?>
</head>

<body>
	<?php	printHeader();	?>

	<section class="lookbook">
		<?php	printLookbook(17, 1, 'ss10-', '2010SS'); ?>

			<a href="2010SS2.php#style">
				<img id="style" src="Images/2010SS/Lookbook/1.jpg" alt="Dress"
				height="599" width="398" />
			</a>
		<p class="floatLeft">
			&quot;MJ&quot; S/S 2010
			<strong>Lookbook</strong>
		</p>
		<p class="floatRight">
			<a href="2010SS17.php#style">prev</a>
			|
			<a href="2010SS2.php#style">next</a>
		</p>
		<?php photo2010SSCredit(); ?>
	</section>

	<?php printFooter(); ?>
</body>

</html>

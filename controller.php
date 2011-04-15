<?php session_start();
error_reporting(0);

function addLinkTags() {
	/*
		<!--[if lte IE 8]>
		<link rel="stylesheet" type="text/css" href="vatleIE.css" title="Normal style" />
		<![endif]-->
	**/?>
	<!--[if gte IE 9]>
	<link rel="stylesheet" type="text/css" href="vatle.css" title="Normal style" />
	<![endif]-->
	<!--[if !IE]><!-->
	<link rel="stylesheet" type="text/css" href="vatle.css" title="Normal style" />
	<!--<![endif]-->
	<link rel="shortcut icon" href="favicon.ico" /> <?php
	addGATrackingCode();
}

function addGATrackingCode() { ?>
	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-22622040-1']);
	  _gaq.push(['_trackPageview']);

	  (function() {
		 var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		 ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		 var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script> <?php
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
					<a href="shop.php" class="shop" title="Shop VATLE">
						SHOP
						<span></span>
					</a>
				</section>

				<section class="floatRight">
					<a href="press.php" class="press" title="The press on VATLE">
						PRESS
						<span></span>
					</a>
					<a href="contact.php" class="contact" title="Contact VATLE">
						CONTACT
						<span></span>
					</a>
					<a href="about.php" class="about" title="About VATLE">
						ABOUT
						<span></span>
					</a> 
				</section>
			</nav>

		</header>
<?php }

function printFooter() { ?>
		<section id="footerPush"></section>
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
	</footer>
<?php }
?>

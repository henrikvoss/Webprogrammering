<?php
function printLookbook($no, $place, $id, $file) {
	echo "<section id='thumbnails'>\n";
	for ($i = 0;  $i < $no;  $i++) {
		if (($i + 1) == $place) {
			echo "<a class='it' id='".$id.($i + 1)."' href='".$file.($i +
				1).".php#style'>".($i +1)."</a>\n";
		}
		else {
			echo "<a id='".$id.($i + 1)."' href='".$file.($i +
				1).".php#style'>".($i +1)."</a>\n";
		}
	}
	echo "</section>\n";
}

function photo2011SSCredit() { ?>
	<p class="floatRight">Photo: Annie Andersson</p>
<?php	}

function photo2010AWCredit() { ?>
	<p class="floatRight">Photo: <a href="http://www.schjetne.net/">Jan Schjetne</a></p>
<?php	}

function photo2010AWMoodCredit1() { ?>
	<p class="floatRight">Photo: Kim Kvalheim</p>
<?php	}

function photo2010AWMoodCredit2() { ?>
	<p class="floatRight">Photo: <a href="http://www.adollshouse.no/hilde/">Hilde Holta-Lysell</a></p>
<?php	}

function photo2010SSCredit() { ?>
	<p class="floatRight">Photo: <a href="http://www.solveigselj.moo.no/">Solveig Selj</a></p>
<?php	}

function photo2009SSCredit() { ?>
	<p class="floatRight">Photo: <a href="http://www.skaalnes.com/">Sveinung Skaalnes</a></p>
<?php	}
?>

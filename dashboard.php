<?php include('controller.php'); ?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />

	<meta name="description" content="Shop for the Norwegian clothing brand VATLE." />

	<meta name="keywords" content="news, Vatle,
	clothing, women&#39;s clothing, soon men&#39;s clothing, designer clothing, Vatle
	designs" />

	<title>Customer Page</title>

	<?php addLinkTags(); ?>
</head>

<body>
	<?php printHeader(); ?>
	<h1>Here you can browse the items in the webshop.</h1>
	
	<form id="request" action="" method="post" >
	    <table border="0" >
			<tr>
	        <td>Choose style:</td>
	        	<td align="right"><select name="style">
					<option value="choose">--Choose a style--</option>
	        		<option value="20SS10">Spring/Summer</option>
			  	</td>
				<td>Price range:</td>
				<td align="right"><select name="price">
					<option value="low">Low (0-&gt;1499)</option>
					<option value="medium">Medium (1500-&gt;2999)</option>
					<option value="high">Low (3000-&gt;)</option>
	        	<td>Show wares:</td>
	        	<td><input type="submit" name="show" VALUE="Show"></td>
	      </tr>
	     </table>
	</form>
	
	
	<?php printFooter(); ?>
</body>

</html>

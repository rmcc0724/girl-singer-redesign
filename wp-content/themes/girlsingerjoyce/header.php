
<!doctype html>
<html>
<head>
<meta charset="utf8">
<title>Girl Singer Joyce</title>

<!--here we add a function call to the header using the wp_head() so it can be included in other files -->
<?php wp_head(); ?>
</head>
	<body>  
	<h1>Here's the header</h1>
	
  <?php wp_nav_menu(array('theme_location'=>'primary')); ?>
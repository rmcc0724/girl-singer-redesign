
<!doctype html>
<html>
<head>
<meta charset="utf8">
<title>Girl Singer Joyce</title>


<?php wp_head(); 

/*
============================================================
-here we add a function call to the header using the wp_head() so it can be included in other files
============================================================
*/

?>

</head>

<?php 
/*
============================================================
This function checks to see if the page is true : it uses the basictheme-class else no-basictheme-class
============================================================
*/
		
		if( is_front_page() ):
			$basictheme_classes = array( 'basictheme-class', 'my-class' );
		else:
			$basictheme_classes = array( 'no-basictheme-class' );
		endif;
	?>
<body <?php body_class( $basictheme_classes ); ?>>
	<h1>Here's the header</h1>
	
  <?php wp_nav_menu(array('theme_location'=>'primary')); ?>
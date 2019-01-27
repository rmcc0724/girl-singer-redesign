
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
			$girlsinger_classes = array( 'girlsinger-class', 'my-class' );
		else:
			$girlsinger_classes = array( 'no-girlsinger-class' );
		endif;
	?>
<body <?php body_class( $girlsinger_classes ); ?>>
	<h1>Here's the header</h1>
	
  <?php wp_nav_menu(array('theme_location'=>'primary')); ?>
  
<!--Here we add the custom header image to the header and set the sizing properties -->

  <img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" />
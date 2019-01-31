
<!DOCTYPE>
<html>

<head>
    <meta charset="utf8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <link href="https://fonts.googleapis.com/css?family=Cormorant+Unicase|Source+Sans+Pro|Roboto" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <title>
        <?php the_title(); ?>
    </title>
    <?php wp_head(); ?>
</head>
<?php  
		if( is_front_page() ):
			$girlsinger_classes = array( 'girlsinger-class', 'my-class' );
		else:
			$girlsinger_classes = array( 'no-girlsinger-class' );
		endif;
	?>
	
<body <?php body_class( $basictheme_classes ); ?>>
    <div class="wrapper m-auto">
    <header class="bg-dark">
        <div class="row">
            <div class='col-12 d-flex justify-content-center text-white pt-3'>
                <h2 class="text-center my-0">JOYCE McCULLOCH</h2>
            </div>
        </div>
        <div class="row">
            <div class='col-12 d-flex justify-content-center text-white pt-2'>
                <p>VOCALIST</p>
            </div>
        </div>

                        </header>     
    <div class="bg-photo">
            <div class="row">
                <div class="d-none d-md-flex col-12 justify-content-center my-1 pt-1">
                    <?php wp_nav_menu(array('theme_location'=>'primary')); ?>
                </div>
            </div>
  

            <div class="row d-xs-block d-md-none mb-1">
                <div class="col-12 m-auto pt-4 text-center">
                    <img id="mobile-photo" class="rounded" style="" src="/wp-content/uploads/2019/01/Joyce_about_mobile-300x300-1.jpg" alt="Joyce McCulloch" />
                </div>
            </div>
            <div class="row d-none d-md-block px-5 bio-wrap">
                <div class="bio p-5 rounded">
                    <img id="main-photo" class="rounded float-left mr-3 mt-2" src="/wp-content/uploads/2019/01/Joyce_about-200x300-1.jpg" alt="Joyce McCulloch" />

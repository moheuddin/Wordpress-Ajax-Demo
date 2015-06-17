<?php

/**
  Plugin Name: Ajax Plugin Demo
  Plugin URI: https://profiles.wordpress.org/vishalkakadiya/
  Version: 1.0
  Author: Vishal Kakadiya
  Contributor: Vishal Kakadiya (https://profiles.wordpress.org/vishalkakadiya/)
  Description: Sample of an AJAX
 */
add_action( 'admin_menu', 'register_my_custom_menu_page' );

function register_my_custom_menu_page() {
	add_menu_page( 'custom menu title', 'custom menu', 'manage_options', 'custompage', 'my_custom_menu_page' );
}

function my_custom_menu_page() {
	echo "<h1>Admin Page Test</h1>";
	echo '<input type="button" id="btn-ajax" value="Click Me" /><br /><br /><br />';
	echo '<div id="ajax-content"></div>';
}

add_action( 'admin_footer', 'my_action_javascript' ); // Write our JS below here

function my_action_javascript() {
	?>
	<script type="text/javascript" >
		jQuery( document ).ready( function ( $ ) {

			jQuery( '#btn-ajax' ).on( 'click', function () {
				var fruit = 'Banana';

				// This does the ajax request
				$.ajax( {
					url: ajaxurl,
					data: {
						'action': 'example_ajax_request',
						'fruit': fruit
					},
					success: function ( data ) {
						// This outputs the result of the ajax request
						$( '#ajax-content' ).html( data );
					},
					error: function ( errorThrown ) {
						console.log( errorThrown );
					}
				} );

			} );

		} );
	</script> <?php

}

function example_ajax_request() {

	// The $_REQUEST contains all the data sent via ajax
	if ( isset( $_REQUEST ) ) {

		$fruit = $_REQUEST['fruit'];

		// Let's take the data that was sent and do something with it
		if ( $fruit == 'Banana' ) {
			$fruit = 'Apple';
		}

		// Now we'll return it to the javascript function
		// Anything outputted will be returned in the response
		echo $fruit;

		// If you're debugging, it might be useful to see what was sent in the $_REQUEST
		// print_r($_REQUEST);
	}

	// Always die in functions echoing ajax content
	die();
}

add_action( 'wp_ajax_example_ajax_request', 'example_ajax_request' );
?>
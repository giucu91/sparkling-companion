<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

add_action( 'admin_enqueue_scripts', 'sparkling_companion_admin_scripts' );
function sparkling_companion_admin_scripts( $hook ) {

	wp_enqueue_style( 'sparkling-companion-admin-css', plugins_url( 'assets/css/admin.css', dirname( __FILE__ ) ) );
	wp_enqueue_script( 'sparkling-companion-admin-js', plugins_url( 'assets/js/admin.js', dirname( __FILE__ ) ), array( 'jquery' ) );
	wp_localize_script( 'sparkling-companion-admin-js', 'sparklingCompanion', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
	) );

	if ( 'widgets.php' == $hook || 'customize.php' == $hook ) {
		wp_enqueue_media();
		wp_enqueue_script( 'sparkling_cloneya_js', plugins_url( 'assets/js/vendor/jquery-cloneya.min.js', dirname( __FILE__ ) ), array( 'jquery' ) );
		wp_enqueue_script( 'widget-js', plugins_url( 'assets/js/widget.js', dirname( __FILE__ ) ), array( 'media-upload' ), '1.0', true );

		// Add Font Awesome stylesheet
		wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css' );
	}
}

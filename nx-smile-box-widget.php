<?php
/*
	Plugin Name: SmileBox Widget
	Plugin URI: https://noxls.net/demo/wp-google-map-clustering/
	Description: People will want to comment, to get into the SmileBox on the site! The widget is designed to stimulate comments, trackbacks and pingbacks on your site, thereby raising the popularity of your site. On the other hand, the unknown always attracted people, they will be to click on a flirty smile and read comments.
	Version: 1.0
	Author: Igor Karpov
    Author URI: https://noxls.net
	Text Domain: smilebox-widget
	Domain Path: /lang
	Requirements: This plugin requires WordPress >= 3.0 and PHP >= 5.1.2

*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

define('NXIK_SMILE_BOX__VERSION', '1.0');
define('NXIK_SMILE_BOX__PLUGIN_URL', plugin_dir_url(__FILE__));
define('NXIK_SMILE_BOX__PLUGIN_DIR', plugin_dir_path(__FILE__));

/* 1. Define the common info. */
include_once( dirname( __FILE__ ) . '/front-end/class/SmileBoxWidget_Commons.php' );
SmileBoxWidget_Commons::setUp( __FILE__ );

/*
 * 2. Front-end
 */
/* 2-1. Localize the plugin */
load_plugin_textdomain( 
	SmileBoxWidget_Commons::TEXTDOMAIN, 
	false, 
	dirname( plugin_basename( __FILE__ ) ) . '/language/'
);
			
/* 2-2. Register the widget */
include_once( dirname( __FILE__ ) . '/front-end/class/SmileBoxWidget.php' );
add_action( 'widgets_init', 'SmileBoxWidget::registerWidget' );


/*
 * 3. Back-end
 */
if ( is_admin() ) {
	
	/* 3-1. Include the admin class. */
	include_once( dirname( __FILE__ ) . '/back-end/class/SmileBoxWidget_Admin.php' );
	new SmileBoxWidget_Admin( __FILE__ );
	
	
}
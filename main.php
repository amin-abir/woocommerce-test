<?php
/**
 * Plugin Name:       Excellent Woocommerce Product Gallery
 * Plugin URI:        creotheme.com
 * Description:       Easily add a carousel to your WooCommerce product gallery.
 * Version:           1.0
 * Author:            creotheme
 * Author URI:        https:creotheme.com
 * Text Domain:       ewpg-creo
 * WC requires at least: 3.6.2
 * WC tested up to: 4.0
 
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Check Condition For Woocommerce Active
 */
	 if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )  ){
	add_action( 'admin_notices', 'ewpg_woocommerce_inactive_notice'  );
	return;
	}
	
	function ewpg_woocommerce_inactive_notice() {
		if ( current_user_can( 'activate_plugins' ) ) :
			if ( !class_exists( 'WooCommerce' ) ) :
				?>
				<div id="message" class="error">
					<p>
						<?php
						printf(
							__( '<strong><span>Excellent woocommerce product gallery required the woocommerce plugin: <em><a href="https://wordpress.org/plugins/woocommerce/" target="_blank">Woocommerce</a></em>.</span></strong>', 'ewpg-creo' )
							
						);
						?>
					</p>
				</div>		
				<?php
			endif;
		endif;
	}
/**
 * wc Version Check function
 */
function ewpg_version_check( $version = '3.0' ) {
	if ( class_exists( 'WooCommerce' ) ) {
		global $woocommerce;
		if ( version_compare( $woocommerce->version, $version, ">=" ) ) {
			return true;

		}
	}
	return false;
}

/**
 * Woocommerce actions
 */

add_action( 'after_setup_theme', 'remove_ewpg_support' );

// Remove default support > woocommerce 3.0 = >

function remove_ewpg_support() {

$zoom_zoom_start = ewpg_get_option( 'zoom_start', 'zoom_magify'); // Setting api Zoom Option

if($zoom_zoom_start == 'false') :
	remove_theme_support( 'wc-product-gallery-zoom' );
else: 
  add_theme_support( 'wc-product-gallery-zoom' );
endif; 
	
	remove_theme_support( 'wc-product-gallery-lightbox' );
	remove_theme_support( 'wc-product-gallery-slider' );

}


add_action('plugins_loaded','after_woo_hooks');

function after_woo_hooks() {
	
 remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );

 add_action( 'woocommerce_before_single_product_summary', 'ewpg_display', 20 );
 

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );

}



/**
 * Register the JS & CSS for the public-facing side of the site.
 *
 */
	function ewpg_enqueue_files() {
		if(is_product()){

		wp_enqueue_script( 'slick-js', plugin_dir_url( __FILE__ ) . 'assets/slick.min.js', array( 'jquery' ),'1.3', false );
		wp_enqueue_script( 'venobox-js', plugin_dir_url( __FILE__ ) . 'assets/venobox.min.js', array( 'jquery' ),'1.3', false );

		wp_enqueue_style( 'dashicons');
		wp_enqueue_style( 'slick-slider', plugin_dir_url( __FILE__ ) . 'assets/slick-theme.css', array(),  '1.3' );
			
		wp_enqueue_style( 'ewpg-style', plugin_dir_url( __FILE__ ) . 'assets/ewpg-style.css', array(),  '1.0' );
		}
		
		}
	
	
add_action( 'wp_enqueue_scripts','ewpg_enqueue_files' );




function ewpg_display() {

		require_once dirname( __FILE__ ) . '/inc/ewpg-display.php';

	
}


/**
 * Get the value of a settings field
 *
 * @param string $option settings field name
 * @param string $section the section name this field belongs to
 * @param string $default default text if it's not found
 * 
 * @return mixed
 */
function ewpg_get_option( $option, $section, $default = '' ) {

    $options = get_option( $section );

    if ( isset( $options[$option] ) ) {
        return $options[$option];
    }

    return $default;
}



	class EWPG_Settings {
        public $plugin_file=__FILE__;
       
        function __construct() {
						
						require_once dirname( __FILE__ ) . '/inc/class.settings-api.php';
						require_once dirname( __FILE__ ) . '/inc/ewpg-settings.php';

						new WeDevs_Settings_API_Test();
    	    
				}
        
    }

    new EWPG_Settings();
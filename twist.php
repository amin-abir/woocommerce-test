<?php
/**
 * Plugin Name:       Woo Slider
 * Plugin URI:        https://codecanyon.net/item/twist-product-gallery-slidercarousel-plugin-for-woocommerce/14849108
 * Description:       Easily add a carousel to your WooCommerce product gallery.
 * Version:           2.1
 * Author:            codeixer
 * Author URI:        https://codecanyon.net/user/codeixer
 * Text Domain:       twist
 * WC requires at least: 3.6.2
 * WC tested up to: 3.6.2
 
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

//update_option( 'Twist_lic_Key', 'activated' );

//require_once "inc/TwistBase.php";
/**
 * Check Condition For Woocommerce Active
 */
	 if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )  ){
	add_action( 'admin_notices', 'twist_woocommerce_inactive_notice'  );
	return;
	}
	
	function twist_woocommerce_inactive_notice() {
		if ( current_user_can( 'activate_plugins' ) ) :
			if ( !class_exists( 'WooCommerce' ) ) :
				?>
				<div id="message" class="error">
					<p>
						<?php
						printf(
							__( '<strong><span>Twist required the woocommerce plugin: <em><a href="https://wordpress.org/plugins/woocommerce/" target="_blank">Woocommerce</a></em>.</span></strong>', 'twist' )
							
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
function twist_version_check( $version = '3.0' ) {
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

add_action( 'after_setup_theme', 'remove_twist_support' );

// Remove default support > woocommerce 3.0 = >

function remove_twist_support() {

$zoom_zoom_start = twist_get_option( 'zoom_start', 'zoom_magify'); // Setting api Zoom Option

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

 add_action( 'woocommerce_before_single_product_summary', 'twist_pgs', 20 );
 
//remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );



}

/**
 * Add Product Video URL fields to media uploader
 *
 * @param $form_fields array, fields to include in attachment form
 * @param $post object, attachment record in database
 * @return $form_fields, modified form fields
 */
 
function twist_add_video_url( $form_fields, $post ) {
	$form_fields['twist-video-url'] = array(
		'label' => 'Video URL',
		'input' => 'text',
		'value' => get_post_meta( $post->ID, 'twist_video_url', true ),
		'helps' => 'Twist Product Video URL',
	);

	

	return $form_fields;
}

/**
 * Save values of Product Video URL fields to media uploader
 *
 * @param $post array, the post data for database
 * @param $attachment array, attachment fields from $_POST form
 * @return $post array, modified post data
 */

function twist_add_video_url_save( $post, $attachment ) {
	if( isset( $attachment['twist-video-url'] ) )
		update_post_meta( $post['ID'], 'twist_video_url', $attachment['twist-video-url'] );

	
	return $post;
}

add_filter( 'attachment_fields_to_edit', 'twist_add_video_url', 10, 2 );
add_filter( 'attachment_fields_to_save', 'twist_add_video_url_save', 10, 2 );

/**
* Dequeue the jQuery UI script.
*
* Hooked to the wp_print_scripts action, with a late priority (100),
* so that it is after the script was enqueued.
*/
// function twist_dequeue_script() {
// wp_dequeue_script( 'cornerstone-site-head' );
// wp_dequeue_script( 'cornerstone-site-body' );
// }

// $themeco = twist_get_option( 'themeco', 'twist_advance','false');
// if($themeco == 'true'){

// add_action( 'wp_print_scripts', 'twist_dequeue_script', 100 );
	
// }

/**
 * Register the JS & CSS for the public-facing side of the site.
 *
 */
	function twist_enqueue_files() {
		if(is_product()){

		wp_enqueue_script( 'slick-js', plugin_dir_url( __FILE__ ) . 'assets/slick.min.js', array( 'jquery' ),'1.3', false );
		wp_enqueue_script( 'venobox-js', plugin_dir_url( __FILE__ ) . 'assets/venobox.min.js', array( 'jquery' ),'1.3', false );

		wp_enqueue_style( 'dashicons');
		wp_enqueue_style( 'slick-twist', plugin_dir_url( __FILE__ ) . 'assets/slick-theme.css', array(),  '1.3' );	
		wp_enqueue_style( 'twist', plugin_dir_url( __FILE__ ) . 'assets/twist.css', array(),  '1.3' );
		}
		
		}
	
	
add_action( 'wp_enqueue_scripts','twist_enqueue_files' );




function twist_pgs() {

	$twist_advance_layout_pb = twist_get_option( 'layout_pb', 'twist_advance','false');

	if($twist_advance_layout_pb == 'false'){
		require_once dirname( __FILE__ ) . '/inc/pgs.php';
	}
	else{
		ob_start();
		require_once dirname( __FILE__ ) . '/inc/pgs.php';
		$output = ob_get_clean();
		return $output;
	}

	
}

$twist_advance_layout_pb = twist_get_option( 'layout_pb', 'twist_advance','false');

if($twist_advance_layout_pb == 'true'){

	add_shortcode( 'twist_vc', 'twist_pgs' );
	add_action( 'vc_before_init', 'twist_vc_map' );

	function twist_vc_map() {
	   vc_map( array(
	      "name" => __( "Twist Product Gallery", "twist" ),
	      "base" => "twist_vc",
		  "description" => __("Product Gallery Slider","twist"),
	      "category" => __( "WooCommerce", "twist"),
	     
	    
	   ) );
	}
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
function twist_get_option( $option, $section, $default = '' ) {

    $options = get_option( $section );

    if ( isset( $options[$option] ) ) {
        return $options[$option];
    }

    return $default;
}



	class Twist {
        public $plugin_file=__FILE__;
        public $responseObj;
        public $licenseMessage;
        public $showMessage=false;
        public $slug="twist";
        function __construct() {
			add_action( 'admin_print_styles', [ $this, 'SetAdminStyle' ] );
			
    	    // $licenseKey=get_option("Twist_lic_Key","");
    	    // if(TwistBase::CheckWPPlugin($licenseKey,$this->licenseMessage,$this->responseObj,__FILE__)){
						
    		//     add_action( 'admin_post_Twist_el_deactivate_license', [ $this, 'action_deactivate_license' ] );
    		    //$this->licenselMessage=$this->mess;
						//Write you plugin's code here
						/**
						 * Setting Options
						 * # https://github.com/tareq1988/wordpress-settings-api-class
						 */
						require_once dirname( __FILE__ ) . '/inc/class.settings-api.php';
						require_once dirname( __FILE__ ) . '/inc/twist-settings.php';

						new WeDevs_Settings_API_Test();
						
						
						


    	    // }else{
    	    //     if(!empty($licenseKey) && !empty($this->licenseMessage)){
    	    //        $this->showMessage=true;
            //     }
    		//     update_option("Twist_lic_Key","") || add_option("Twist_lic_Key","");
    		//     add_action( 'admin_post_Twist_el_activate_license', [ $this, 'action_activate_license' ] );
    		//     add_action( 'admin_menu', [$this,'InactiveMenu']);
    	    // }
				}
				

    	function SetAdminStyle() {
    		wp_register_style( "TwistLic", plugins_url("/inc/style.css",$this->plugin_file),10);
    		wp_enqueue_style( "TwistLic" );
    	}
        function ActiveAdminMenu(){
					
				
					add_submenu_page( "woocommerce", "Twist License Info", 'Twist License Info', 'manage_options', $this->slug, [$this,"Activated"] );
			

        }
        function InactiveMenu() {
				
					add_submenu_page( "woocommerce", "Twist Activation", 'Twist Activation', 'manage_options', $this->slug, [$this,"LicenseForm"] );

        }
        function action_activate_license(){

    	    check_admin_referer( 'el-license' );
    	    $licenseKey=!empty($_POST['el_license_key'])?$_POST['el_license_key']:"";
    	    update_option("Twist_lic_Key",$licenseKey) || add_option("Twist_lic_Key",$licenseKey);
    	    wp_safe_redirect(admin_url( 'admin.php?page='.$this->slug));
        }
         function action_deactivate_license() {
    	    check_admin_referer( 'el-license' );
    	    if(TwistBase::RemoveLicenseKey(__FILE__,$message)){
    		    update_option("Twist_lic_Key","") || add_option("Twist_lic_Key","");
    	    }
    	    wp_safe_redirect(admin_url( 'admin.php?page='.$this->slug));
        }
         function Activated(){
            ?>
          
                <div class="el-license-container">
                    <h2 class="el-license-title"><i class="dashicons-before dashicons-star-filled"></i> Twist License Info</h2>
                    <hr>
                    <ul class="el-license-info">
                    <li>
                        <div>
                            <span class="el-license-info-title">Status</span>

    			            <?php if ( $this->responseObj->is_valid ) : ?>
                                <span class="el-license-valid">Valid</span>
    			            <?php else : ?>
                                <span class="el-license-valid">Invalid</span>
    			            <?php endif; ?>
                        </div>
                    </li>

                    <li>
                        <div>
                            <span class="el-license-info-title">License Type</span>
    			            <?php echo $this->responseObj->license_title; ?>
                        </div>
                    </li>

                    <li>
                        <div>
                            <span class="el-license-info-title">License Expired on</span>
    			            <?php echo $this->responseObj->expire_date; ?>
                        </div>
                    </li>

                    <li>
                        <div>
                            <span class="el-license-info-title">Support Expired on</span>
    			            <?php echo $this->responseObj->support_end; ?>
                        </div>
                    </li>
                        <li>
                            <div>
                                <span class="el-license-info-title">Your License Key</span>
                                <span class="el-license-key"><?php echo esc_attr( substr($this->responseObj->license_key,0,9)."XXXXXXXX-XXXXXXXX".substr($this->responseObj->license_key,-9) ); ?></span>
                            </div>
                        </li>
                    </ul>
                    <div class="el-license-active-btn">
                    </div>
                </div>
            
    	<?php
        }

        function LicenseForm() {
    	    ?>
        <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
    	    <input type="hidden" name="action" value="Twist_el_activate_license"/>
    	    <div class="el-license-container">
    		    <h3 class="el-license-title"><i class="dashicons-before dashicons-star-filled"></i> Twist Licensing</h3>
    		    <hr>
                <?php
                if(!empty($this->showMessage) && !empty($this->licenseMessage)){
                    ?>
                    <div class="notice notice-error is-dismissible">
                        <p><?php echo $this->licenseMessage; ?></p>
                    </div>
                    <?php
                }
                ?>
    		    <p class="about-description">Enter your Purchase key here, to activate the product, and get full feature updates and premium support.</p>
    		    
						
    		    <div class="el-license-field">
    			    
    			    <input type="text" class="regular-text code" name="el_license_key" size="50" placeholder="xxxxxxxx-xxxxxxxx-xxxxxxxx-xxxxxxxx" required="required">
							<small class="plsde"><a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-
    			   " target="_blank">Where Is My Purchase Code?</a></small>
    		    </div>

    		    <div class="el-license-active-btn">
    			    <?php wp_nonce_field( 'el-license' ); ?>
    			    <?php submit_button('Activate'); ?>
    		    </div>
    	    </div>
        </form>
    	    <?php
        }
    }

    new Twist();
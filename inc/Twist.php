<?php
    /*
    Plugin Name: Twist
    Plugin URI:
    Description: simple description
    Version: 1.0.0.0
    */

    require_once "TwistBase.php";

	class Twist {
        public $plugin_file=__FILE__;
        public $responseObj;
        public $licenseMessage;
        public $showMessage=false;
        public $slug="twist";
        function __construct() {
    	    add_action( 'admin_print_styles', [ $this, 'SetAdminStyle' ] );
    	    $licenseKey=get_option("Twist_lic_Key","");
    	    if(TwistBase::CheckWPPlugin($licenseKey,$this->licenseMessage,$this->responseObj,__FILE__)){
    		    add_action( 'admin_menu', [$this,'ActiveAdminMenu']);
    		    add_action( 'admin_post_Twist_el_deactivate_license', [ $this, 'action_deactivate_license' ] );
    		    //$this->licenselMessage=$this->mess;
    		    //Write you plugin's code here

    	    }else{
    	        if(!empty($licenseKey) && !empty($this->licenseMessage)){
    	           $this->showMessage=true;
                }
    		    update_option("Twist_lic_Key","") || add_option("Twist_lic_Key","");
    		    add_action( 'admin_post_Twist_el_activate_license', [ $this, 'action_activate_license' ] );
    		    add_action( 'admin_menu', [$this,'InactiveMenu']);
    	    }
        }
    	function SetAdminStyle() {
    		wp_register_style( "TwistLic", plugins_url("style.css",$this->plugin_file),10);
    		wp_enqueue_style( "TwistLic" );
    	}
        function ActiveAdminMenu(){
    	    add_menu_page (  "Twist", "Twist", 'activate_plugins', $this->slug, [$this,"Activated"], " dashicons-star-filled ");

        }
        function InactiveMenu() {
    	    add_menu_page( "Twist", "Twist", 'activate_plugins', $this->slug,  [$this,"LicenseForm"], " dashicons-star-filled " );

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
            <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                <input type="hidden" name="action" value="Twist_el_deactivate_license"/>
                <div class="el-license-container">
                    <h3 class="el-license-title"><i class="dashicons-before dashicons-star-filled"></i> Twist License Info</h3>
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
    				    <?php wp_nonce_field( 'el-license' ); ?>
    				    <?php submit_button('Deactivate'); ?>
                    </div>
                </div>
            </form>
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
    		    <p>Enter your license key here, to activate the product, and get full feature updates and premium support.</p>
    		    <ol>
    			    <li>Write your licnese key details</li>
    			    <li>How buyer will get this license key?</li>
    			    <li>Describe other info about licensing if rquired</li>
                    <li>. ...</li>
    		    </ol>
    		    <div class="el-license-field">
    			    <label for="el_license_key">License code</label>
    			    <input type="text" class="regular-text code" name="el_license_key" size="50" placeholder="xxxxxxxx-xxxxxxxx-xxxxxxxx-xxxxxxxx" required="required">
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
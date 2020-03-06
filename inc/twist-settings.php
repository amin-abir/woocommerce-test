<?php

/**
 * WordPress settings API demo class
 *
 * @author Tareq Hasan
 */
if ( !class_exists('WeDevs_Settings_API_Test' ) ):
class WeDevs_Settings_API_Test {

    private $settings_api;
    //public $responseObj;

    function __construct() {

        
        $this->settings_api = new WeDevs_Settings_API;

        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );
    }
     
    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    function admin_menu() {
        add_submenu_page( 
            'woocommerce', 'Twist Settings', 'Twist Settings', 'manage_options', 'twist', array(&$this, 'plugin_page')
        );
    }
       
    function get_settings_sections() {


        $sections = array(
            array(
                'id'    => 'genaral_options',
                'title' => __( 'General Settings', 'twist' )
            ),
            array(
                'id'    => 'single_options',
                'title' => __( 'Feature Image Options', 'twist' )
            ),
            array(
                'id'    => 'lightbox_options',
                'title' => __( 'LightBox Options', 'twist' )
            ),
            array(
                'id'    => 'zoom_magify',
                'title' => __( 'Zoom Options', 'twist' )
            ),
            
            array(
                'id'    => 'wedevs_advanced',
                'title' => __( ' Twist License Info', 'twist' )
            )
        );
        return $sections;
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields() {
        $settings_fields = array(
            'genaral_options' => array(
                array(
                    'name'    => 'layout',
                    'label'   => __( 'Gallery Layout', 'twist' ),
                    
                    'type'    => 'select',
                    'default' => 'horizontal',
                    'options' => array(
                        'vertical' => 'Vertical Left',
                        'vertical_r' => 'Vertical Right',
                        'horizontal'  => 'Horizontal'
                    )
                ),
                 array(
                    'name'              => 'thum2show',
                    'label'             => __( 'Thumbnails To Show', 'twist' ),
                    'type'              => 'number',
                    'default'           => '4',
                    'sanitize_callback' => 'sanitize_text_field'
                ),

                 array(
                    'name'              => 'thumscrollby',
                    'label'             => __( 'Thumbnails Scroll By', 'twist' ),
                    'desc'  => __('Note: You can set the number of thumbails for scrolling when arrows are clicked','twist'),
                    'type'              => 'number',
                    'default'           => '3',
                    'sanitize_callback' => 'sanitize_text_field'
                ),

               
                array(
                    'name'    => 'lightbox',
                    'label'   => __( 'LightBox For Thumbnails', 'twist' ),
                    
                    'type'    => 'checkbox',
                    'default' => 'false',
                    'options' => array(
                        'true' => 'Yes',
                        'false'  => 'No'
                    )
                ),
               
                array(
                    'name'    => 'infinite',
                    'label'   => __( 'Infinite', 'twist' ),
                    
                    'type'    => 'checkbox',
                    'default' => 'false',
                    'options' => array(
                        'true' => 'Yes',
                        'false'  => 'No'
                    )
                ),
                array(
                    'name'    => 'dragging',
                    'label'   => __( 'Mouse Dragging', 'twist' ),
                   
                    'type'    => 'checkbox',
                    'default' => 'false',
                    'options' => array(
                        'true' => 'Yes',
                        'false'  => 'No'
                    )
                ),
                array(
                    'name'    => 'rtl',
                    'label'   => __( 'RTL Mode', 'twist' ),
                    
                    'type'    => 'checkbox',
                    'default' => 'false',
                    'options' => array(
                        'true' => 'Yes',
                        'false'  => 'No'
                    )
                ),
                
                array(
                    'name'    => 'autoplay',
                    'label'   => __( 'Autoplay', 'twist' ),
                    'desc'  => __('Note: This option will not work if "LightBox For Gallery" Trun on','twist'),
                    'type'    => 'checkbox',
                    
                    'default' => 'false',
                    'options' => array(
                        'true' => 'Yes',
                        'false'  => 'No'
                    )
                ),
               
                array(
                    'name'    => 'autoplaySpeed',
                    'label'   => __( 'AutoPlay Timeout', 'twist' ),
                    'desc'              => __( '1000 = 1 Sec', 'twist' ),
                    'type'    => 'text',
                    'default' => '5000',
                    
                ),
                array(
                    'name'    => 'video_icon_color',
                    'label'   => __( 'Video Icon Color', 'twist' ),
                    
                    'type'    => 'color',
                    'default' => '#e54634'
                ),
                array(
                    'name'    => 'nav_icon_color',
                    'label'   => __( 'Navigation Icon Color', 'twist' ),
                    
                    'type'    => 'color',
                    'default' => '#fff'
                ),
                array(
                    'name'    => 'nav_bg_color',
                    'label'   => __( 'Navigation Background Color', 'twist' ),
                    
                    'type'    => 'color',
                    'default' => '#000000'
                ),
            ),
        
            'single_options' => array(

               
                array(
                    'name'    => 'hide_nav',
                    'label'   => __( 'Navigation Arrow', 'twist' ),
                    'desc'    => __( 'Enable This Option if you want To keep Arrow Always Visiable', 'twist' ),
                    'type'    => 'checkbox',
                    'default' => 'false',
                    'options' => array(
                        'true' => 'Yes',
                        'false'  => 'No'
                    )
                ),
                array(
                    'name'    => 'fade',
                    'label'   => __( 'Fade Effect', 'twist' ),
                    
                    'type'    => 'checkbox',
                    'default' => 'false',
                    'options' => array(
                        'true' => 'Yes',
                        'false'  => 'No'
                    )
                ),
                array(
                    'name'    => 'swipe',
                    'label'   => __( 'Swipe To Slide', 'twist' ),
                    
                    'type'    => 'checkbox',
                    'default' => 'true',
                    'options' => array(
                        'true' => 'Yes',
                        'false'  => 'No'
                    )
                ),
                array(
                    'name'    => 'dots',
                    'label'   => __( 'Dots', 'twist' ),
                    'desc'    => __( 'Note: This option will not work if "LightBox For Gallery" Trun on under the "General options" Tab', 'twist' ),
                    'type'    => 'checkbox',
                    'default' => 'false',
                    'options' => array(
                        'true' => 'Yes',
                        'false'  => 'No'
                    )
                ),
                array(
                    'name'    => 'resize_height',
                    'label'   => __( 'Resize Height', 'twist' ),
                    'desc'    => __( 'If you Gallery has multiple Image size, you need to Enable it for avoid White space Under the gallery', 'twist' ),
                    'type'    => 'checkbox',
                    'default' => 'false',
                    'options' => array(
                        'true' => 'Yes',
                        'false'  => 'No'
                    )
                ),
                array(
                    'name'    => 'hide_gallery',
                    'label'   => __( 'Hide Thumbnails', 'twist' ),
                    
                    'type'    => 'checkbox',
                    'default' => 'false',
                    'options' => array(
                        'true' => 'Yes',
                        'false'  => 'No'
                    )
                ),
                
               
                
                
            ),
            'lightbox_options' => array(
                array(
                    'name'    => 'disable_lightbox',
                    'label'   => __( 'Disable Lightbox', 'twist' ),
                    'desc' => 'Enable it for Disable Lightbox.<br/> Note: below options are not working if this option is Enable.',
                    'type'    => 'checkbox',
                    'default' => 'false',
                    'options' => array(
                        'true' => 'Yes',
                        'false'  => 'No'
                    )
                ),
                array(
                    'name'    => 'arrowsColor',
                    'label'   => __( 'Navigation Arrows Color', 'twist' ),
                    
                    'type'    => 'color',
                    'default' => '#fff'
                ),
                array(
                    'name'    => 'bgcolor',
                    'label'   => __( 'Image Border Color', 'twist' ),
                    
                    'type'    => 'color',
                    'default' => '#fff'
                ),
                array(
                    'name'    => 'lightbox_framewidth',
                    'label'   => __( 'Image Frame Width', 'twist' ),
                    'desc'              => __( 'If the Lightbox image is not Fit to the Screen than you can use this option. <br>Default: 800(in Pixel)', 'twist' ),
                    'type'    => 'number',
                    'default' => '800',
                    
                ),
                array(
                    'name'              => 'borderwidth',
                    'label'             => __( 'Image Border Width', 'twist' ),
                    'desc'              =>__('In Pixel','twist'),
                    'type'              => 'number',
                    'default'           => '5',
                    'sanitize_callback' => 'sanitize_text_field'
                ),
                array(
                    'name'    => 'spinColor',
                    'label'   => __( 'Preloader color', 'twist' ),
                    
                    'type'    => 'color',
                    'default' => '#fff'
                ),
                array(
                    'name'    => 'spinner1',
                    'label'   => __( 'Preloader', 'twist' ),
                    
                    'type'    => 'select',
                    'default' => 'cube-grid',
                    'options' => array(
                        'rotating-plane' => 'Rotating Plane',
                        'double-bounce'  => 'Double Bounce',
                        'wave'  => 'Wave',
                        'cube-grid'  => 'Cube Grid',
                        'three-bounce'  => 'Three Bounce',
                        'spinner-pulse'  => 'Spinner Pulse',
                        'wandering-cubes'  => 'Wandering Cubes'
                    )
                ),

              

                array(
                    'name'    => 'lightbox_infinite',
                    'label'   => __( 'Infinite', 'twist' ),
                    
                    'type'    => 'checkbox',
                    'default' => 'false',
                    'options' => array(
                        'true' => 'Yes',
                        'false'  => 'No'
                    )
                ),
                array(
                    'name'    => 'autoplay_videos',
                    'label'   => __( 'Automatic play for videos', 'twist' ),
                    
                    'type'    => 'checkbox',
                    'default' => 'true',
                    'options' => array(
                        'true' => 'Yes',
                        'false'  => 'No'
                    )
                ),
                array(
                    'name'    => 'numeratio',
                    'label'   => __( 'Show Navigation number', 'twist' ),
                    
                    'type'    => 'checkbox',
                    'default' => 'true',
                    'options' => array(
                        'true' => 'Yes',
                        'false'  => 'No'
                    )
                ),
                array(
                    'name'    => 'titlePosition',
                    'label'   => __( 'Title Position', 'wedevs' ),
                    
                    'type'    => 'select',
                    'default' => 'bottom',
                    'options' => array(
                        'top' => 'Top',
                        'bottom'  => 'Bottom'
                    )
                ),
                array(
                    'name'    => 'titleBackground',
                    'label'   => __( 'Title background color', 'twist' ),
                    
                    'type'    => 'color',
                    'default' => '#000000'
                ),
                array(
                    'name'    => 'titleColor',
                    'label'   => __( 'Title Text Color', 'twist' ),
                    
                    'type'    => 'color',
                    'default' => '#fff'
                ),
                
            ),
            
            'zoom_magify' => array(

                array(
                    'name'    => 'zoom_start',
                    'label'   => __( 'Zoom', 'twist' ),
                    'desc'        => __( 'Turn on Woocommerce Default Zoom for Single Products', 'twist' ),
                    'type'    => 'checkbox',
                    'default' => 'false',
                    'options' => array(
                        'true' => 'Yes',
                        'false'  => 'No'
                    )
                ),
            ),
            'wedevs_advanced' => array(
                
                array(
                    'name'        => 'support',
                    'desc'        => __( '
                                                
                        <h3>Thank you for purchasing and activating <strong>« Twist »</strong> Plugin !</h3>
                        <p class="about-description">Every month, we try to release a new update for this Plugin with bugs fixed.<br>
                        If you found any problems in this Plugin please let us know. we will try to fix it ASAP.<br></p><br>


                       
                        
                        <a target="_blank" href="http://codeixer.com/s"><span class="dashicons dashicons-sos" style="
                            text-decoration: none;
                            font-size: 19px;
                        "></span> Plugin Support</a>
                        </span></strong>
                        ', 'twist' ),
                    'type'        => 'html'
                ),
           
            )
        );

        return $settings_fields;
        
      
    }

    function plugin_page() {
        echo '<div class="wrap wppine-backend-style">';

        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();
       
       
        echo '</div>';
    }


}
endif;

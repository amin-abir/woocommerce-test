<?php

/**
 * WordPress settings API demo class
 *
 * @author Tareq Hasan
 */
if ( !class_exists('WeDevs_Settings_API_Test' ) ):
class WeDevs_Settings_API_Test {

    private $settings_api;
  

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
        add_menu_page( 
             'EWPG Settings',
              'EWPG Settings',
               'manage_options',
                'ewpg-settings', 
                array(&$this, 'plugin_page'),
                'dashicons-chart-pie'
        );
    }
       
    function get_settings_sections() {


        $sections = array(
            array(
                'id'    => 'genaral_options',
                'title' => __( 'Gallery Settings', 'ewpg-creo' )
            ),
            array(
                'id'    => 'single_options',
                'title' => __( 'Feature Image Settings', 'ewpg-creo' )
            ),
            array(
                'id'    => 'lightbox_options',
                'title' => __( 'LightBox Settings', 'ewpg-creo' )
            ),
            // array(
            //     'id'    => 'zoom_magify',
            //     'title' => __( 'Zoom Options', 'ewpg-creo' )
            // ),
            
            array(
                'id'    => 'wedevs_advanced',
                'title' => __( 'License Info', 'ewpg-creo' )
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
                    'label'   => __( 'Gallery Layout', 'ewpg-creo' ),
                    
                    'type'    => 'select',
                    'default' => 'vertical',
                    'options' => array(
                        'vertical' => 'Vertical Left',
                        'vertical_r' => 'Vertical Right',
                        'horizontal'  => 'Horizontal'
                    )
                ),
                 array(
                    'name'              => 'thum2show',
                    'label'             => __( 'Thumbnails To Show', 'ewpg-creo' ),
                    'type'              => 'number',
                    'desc'  => __('Number of thumbails to show in gallery','ewpg-creo'),
                    'default'           => '4',
                    'sanitize_callback' => 'sanitize_text_field'
                ),

                 array(
                    'name'              => 'thumscrollby',
                    'label'             => __( 'Thumbnails Scroll By', 'ewpg-creo' ),
                    'desc'  => __('Number of thumbails for scrolling when arrows are clicked','ewpg-creo'),
                    'type'              => 'number',
                    'default'           => '3',
                    'sanitize_callback' => 'sanitize_text_field'
                ),

               
                array(
                    'name'    => 'lightbox',
                    'label'   => __( 'LightBox For Thumbnails', 'ewpg-creo' ),
                    
                    'type'    => 'checkbox',
                    'default' => 'false',
                    'options' => array(
                        'true' => 'Yes',
                        'false'  => 'No'
                    )
                ),
               
                array(
                    'name'    => 'infinite',
                    'label'   => __( 'Infinite', 'ewpg-creo' ),
                    
                    'type'    => 'checkbox',
                    'default' => 'false',
                    'options' => array(
                        'true' => 'Yes',
                        'false'  => 'No'
                    )
                ),
                array(
                    'name'    => 'dragging',
                    'label'   => __( 'Mouse Dragging', 'ewpg-creo' ),
                   
                    'type'    => 'checkbox',
                    'default' => 'false',
                    'options' => array(
                        'true' => 'Yes',
                        'false'  => 'No'
                    )
                ),
                array(
                    'name'    => 'rtl',
                    'label'   => __( 'RTL Mode', 'ewpg-creo' ),
                    
                    'type'    => 'checkbox',
                    'default' => 'false',
                    'options' => array(
                        'true' => 'Yes',
                        'false'  => 'No'
                    )
                ),
                
                array(
                    'name'    => 'autoplay',
                    'label'   => __( 'Autoplay', 'ewpg-creo' ),
                    'desc'  => __('Autoplay will not work if lightbox for thumbnail is enabled','ewpg-creo'),
                    'type'    => 'checkbox',
                    
                    'default' => 'false',
                    'options' => array(
                        'true' => 'Yes',
                        'false'  => 'No'
                    )
                ),
               
                array(
                    'name'    => 'autoplaySpeed',
                    'label'   => __( 'AutoPlay Timeout', 'ewpg-creo' ),
                    'desc'              => __( '1000 = 1 Sec', 'ewpg-creo' ),
                    'type'    => 'text',
                    'default' => '4000',
                    
                ),
                
                array(
                    'name'    => 'nav_icon_color',
                    'label'   => __( 'Navigation Icon Color', 'ewpg-creo' ),
                    
                    'type'    => 'color',
                    'default' => '#fff'
                ),
                array(
                    'name'    => 'nav_bg_color',
                    'label'   => __( 'Navigation Background Color', 'ewpg-creo' ),
                    
                    'type'    => 'color',
                    'default' => '#000000'
                ),
            ),
        
            'single_options' => array(

               
                array(
                    'name'    => 'hide_nav',
                    'label'   => __( 'Navigation Arrow', 'ewpg-creo' ),
                    'desc'    => __( 'Navigation Arrow Always Visiable', 'ewpg-creo' ),
                    'type'    => 'checkbox',
                    'default' => 'false',
                    'options' => array(
                        'true' => 'Yes',
                        'false'  => 'No'
                    )
                ),
                array(
                    'name'    => 'fade',
                    'label'   => __( 'Fade Effect', 'ewpg-creo' ),
                    
                    'type'    => 'checkbox',
                    'default' => 'false',
                    'options' => array(
                        'true' => 'Yes',
                        'false'  => 'No'
                    )
                ),
                array(
                    'name'    => 'swipe',
                    'label'   => __( 'Swipe To Slide', 'ewpg-creo' ),
                    
                    'type'    => 'checkbox',
                    'default' => 'true',
                    'options' => array(
                        'true' => 'Yes',
                        'false'  => 'No'
                    )
                ),
                array(
                    'name'    => 'dots',
                    'label'   => __( 'Dots', 'ewpg-creo' ),
                    'desc'    => __( 'Note: This option will not work if "LightBox For Gallery" Trun on under the "General options" Tab', 'ewpg-creo' ),
                    'type'    => 'checkbox',
                    'default' => 'false',
                    'options' => array(
                        'true' => 'Yes',
                        'false'  => 'No'
                    )
                ),
                array(
                    'name'    => 'resize_height',
                    'label'   => __( 'Resize Height', 'ewpg-creo' ),
                    'desc'    => __( 'If you Gallery has multiple Image size, you need to Enable it for avoid White space Under the gallery', 'ewpg-creo' ),
                    'type'    => 'checkbox',
                    'default' => 'false',
                    'options' => array(
                        'true' => 'Yes',
                        'false'  => 'No'
                    )
                ),
                array(
                    'name'    => 'hide_gallery',
                    'label'   => __( 'Hide Thumbnails', 'ewpg-creo' ),
                    
                    'type'    => 'checkbox',
                    'default' => 'false',
                    'options' => array(
                        'true' => 'Yes',
                        'false'  => 'No'
                    )
                ),


                    array(
                        'name'    => 'zoom_start',
                        'label'   => __( 'Woocommerce Zoom', 'ewpg-creo' ),
                        'desc'        => __( 'Turn on Woocommerce Default Zoom for Single Products', 'ewpg-creo' ),
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
                    'label'   => __( 'Disable Lightbox', 'ewpg-creo' ),
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
                    'label'   => __( 'Lightbox Navigation Arrows Color', 'ewpg-creo' ),
                    
                    'type'    => 'color',
                    'default' => '#fff'
                ),
                array(
                    'name'    => 'bgcolor',
                    'label'   => __( 'Lightbox Image Border Color', 'ewpg-creo' ),
                    
                    'type'    => 'color',
                    'default' => '#fff'
                ),
                array(
                    'name'    => 'lightbox_framewidth',
                    'label'   => __( 'Image Frame Width', 'ewpg-creo' ),
                    'desc'              => __( 'Option to display lightbox image in your screen<br>By default: 900(in Pixel)', 'ewpg-creo' ),
                    'type'    => 'number',
                    'default' => '900',
                    
                ),
                array(
                    'name'              => 'borderwidth',
                    'label'             => __( 'Image Border Width', 'ewpg-creo' ),
                    'desc'              =>__('In Pixel','ewpg-creo'),
                    'type'              => 'number',
                    'default'           => '3',
                    'sanitize_callback' => 'sanitize_text_field'
                ),
                array(
                    'name'    => 'spinColor',
                    'label'   => __( 'Preloader color', 'ewpg-creo' ),
                    
                    'type'    => 'color',
                    'default' => '#fff'
                ),
                array(
                    'name'    => 'spinner1',
                    'label'   => __( 'Preloader', 'ewpg-creo' ),
                    
                    'type'    => 'select',
                    'default' => 'cube-grid',
                    'options' => array(
                        'rotating-plane' => 'Rotating Plane',
                        'double-bounce'  => 'Double Bounce',
                        'wave'  => 'Wave',
                        'cube-grid'  => 'Cube Grid',
                        'three-bounce'  => 'Three Bounce',
                    )
                ),

              

                array(
                    'name'    => 'lightbox_infinite',
                    'label'   => __( 'Infinite', 'ewpg-creo' ),
                    
                    'type'    => 'checkbox',
                    'default' => 'false',
                    'options' => array(
                        'true' => 'Yes',
                        'false'  => 'No'
                    )
                ),
               
                array(
                    'name'    => 'numeratio',
                    'label'   => __( 'Show Navigation number', 'ewpg-creo' ),
                    
                    'type'    => 'checkbox',
                    'default' => 'true',
                    'options' => array(
                        'true' => 'Yes',
                        'false'  => 'No'
                    )
                ),
                array(
                    'name'    => 'titlePosition',
                    'label'   => __( 'Title Position', 'ewpg-creo' ),
                    
                    'type'    => 'select',
                    'default' => 'bottom',
                    'options' => array(
                        'top' => 'Top',
                        'bottom'  => 'Bottom'
                    )
                ),
                array(
                    'name'    => 'titleBackground',
                    'label'   => __( 'Title background color', 'ewpg-creo' ),
                    
                    'type'    => 'color',
                    'default' => '#000000'
                ),
                array(
                    'name'    => 'titleColor',
                    'label'   => __( 'Title Text Color', 'ewpg-creo' ),
                    
                    'type'    => 'color',
                    'default' => '#fff'
                ),
                
            ),
            
            
            'wedevs_advanced' => array(
                
                array(
                    'name'        => 'support',
                    'desc'        => __( '
                                                
                        
                        <p class="about-description">Every month, we try to release a new update for this Plugin with bugs fixed.<br>
                        If you found any problems in this Plugin please let us know. we will try to fix it ASAP.<br></p><br>


                       
                        
                        <a target="_blank" href="#"><span class="dashicons dashicons-sos" style="
                            text-decoration: none;
                            font-size: 19px;
                        "></span> Plugin Support</a>
                        </span></strong>
                        ', 'ewpg-creo' ),
                    'type'        => 'html'
                ),
           
            )
        );

        return $settings_fields;
        
      
    }

    function plugin_page() {
        echo '<div class="wrap ewpg-admin-wrap">';

        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();
       
       
        echo '</div>';
    }


}
endif;

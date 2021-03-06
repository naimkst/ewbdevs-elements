<?php
namespace ewebdevselements;

//use ewebdevselements\Widgets\Section_Title;
use ewebdevselements\Widgets\Testimonial_One;
use ewebdevselements\Widgets\Testimonial_Two;

/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 1.2.0
 */
class ewebdevselements {

    /**
     * Instance
     *
     * @since 1.2.0
     * @access private
     * @static
     *
     * @var Plugin The single instance of the class.
     */
    private static $_instance = null;

    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @since 1.2.0
     * @access public
     *
     * @return Plugin An instance of the class.
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * widget_scripts
     *
     * Load required plugin core files.
     *
     * @since 1.2.0
     * @access public
     */
//    public function widget_scripts() {
//        wp_register_script( 'langona-contact', plugins_url( '/assets/js/contact.js', __FILE__ ), array('jquery'), time(), true );
//        $ajax_url = admin_url('admin-ajax.php');
//        wp_localize_script('langona-contact','langona',['ajax_url'=>$ajax_url]);
//    }

    /**
     * Include Widgets files
     *
     * Load widgets files
     *
     * @since 1.2.0
     * @access private
     */
    private function include_widgets_files() {
        //require_once __DIR__ . '/widgets/title.php';
        require_once __DIR__ . '/widgets/testimonial-one.php';
        require_once __DIR__ . '/widgets/testimonial-two.php';
    }

    /**
     * Register Widgets
     *
     * Register new Elementor widgets.
     *
     * @since 1.2.0
     * @access public
     */
    public function register_widgets() {
        // Its is now safe to include Widgets files
        $this->include_widgets_files();

        // Register Widgets
        //\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Section_Title() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Testimonial_One() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Testimonial_Two() );

    }

    /**
     *  Plugin class constructor
     *
     * Register plugin action hooks and filters
     *
     * @since 1.2.0
     * @access public
     */


    public function __construct() {

        // Register widgets
        add_action( 'elementor/widgets/widgets_registered', array($this, 'register_widgets') );

        // Register widgets category
        add_action( 'elementor/elements/categories_registered', [ $this, 'register_new_category'] );
    }

    public function register_new_category($manager){
        $manager->add_category('ewebdevs_elements', [
            'title'=>__('Ewebdevs Elements', 'ewebdevs-elements'),
            'icon'=>'fa fa-image'
        ]);
    }

}

// Instantiate Plugin Class
ewebdevselements::instance();

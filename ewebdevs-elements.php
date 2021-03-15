<?php
/**
 * Plugin Name: Ewebdevs Elements
 * Description: Ewebdevs Elements plugin for custom widget
 * Plugin URI:  https://ewebdevs.com/blog
 * Version:     1.0.0
 * Author:      naimkst
 * Author URI:  https://ewebdevs.com
 * Text Domain: ewebdevs-elements
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Main langona Companion Class
 *
 * Intended To make sure that the plugin's minimum requirements are met.
 *
 * You should only modify the constants to match your plugin's needs.
 *
 * Any custom code should go inside Plugin Class in the plugin.php file.
 * @since 1.2.0
 */


final class ewebdevselements {

    /**
     * Plugin Version
     *
     * @since 1.2.0
     * @var string The plugin version.
     */
    const VERSION = '1.2.0';

    /**
     * Minimum Elementor Version
     *
     * @since 1.2.0
     * @var string Minimum Elementor version required to run the plugin.
     */
    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

    /**
     * Minimum PHP Version
     *
     * @since 1.2.0
     * @var string Minimum PHP version required to run the plugin.
     */
    const MINIMUM_PHP_VERSION = '7.0';

    /**
     * Constructor
     *
     * @since 1.0.0
     * @access public
     */
    public function __construct() {

        // Load translation
        add_action( 'init', array( $this, 'i18n' ) );

        // Init Plugin
        add_action( 'plugins_loaded', array( $this, 'init' ) );
    }

    /**
     * Load Textdomain
     *
     * Load plugin localization files.
     * Fired by `init` action hook.
     *
     * @since 1.2.0
     * @access public
     */
    public function i18n() {
        load_plugin_textdomain( 'ewebdevs-elements', plugins_url() . '/languages' );
    }

    /**
     * Initialize the plugin
     *
     * Validates that Elementor is already loaded.
     * Checks for basic plugin requirements, if one check fail don't continue,
     * if all check have passed include the plugin class.
     *
     * Fired by `plugins_loaded` action hook.
     *
     * @since 1.2.0
     * @access public
     */

    public function init() {

        // Check if Elementor installed and activated
        if ( ! did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
            return;
        }

        // Check for required Elementor version
        if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
            return;
        }

        // Check for required PHP version
        if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
            return;
        }

        add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'widget_styles'] );
        add_action( "elementor/frontend/after_enqueue_scripts", [ $this, 'widget_fronted_scripts' ] );

        // Once we get here, We have passed all validation checks so we can safely include our plugin
        require_once( 'plugin.php' );
    }

    function widget_fronted_scripts(){
        wp_enqueue_script("popper-js",plugins_url("/assets/js/popper.js",__FILE__),array('jquery'),'5.0.0',true);
        wp_enqueue_script("min-js",plugins_url("/assets/js/min.min.js",__FILE__),array('jquery'),'5.0.0',true);
        wp_enqueue_script("placeholdem-js",plugins_url("/assets/js/placeholdem.min.js",__FILE__),array('jquery'),'5.0.0',true);
        wp_enqueue_script("slick-js",plugins_url("/assets/js/lib/slick/slick.js",__FILE__),array('jquery'),'5.0.0',true);
        wp_enqueue_script("script-js",plugins_url("/assets/js/script.js",__FILE__),array('jquery'),'5.0.0',true);
    }

    function widget_styles(){
        wp_enqueue_style("animate-css", plugins_url("/assets/css/animate.css", __FILE__));
        wp_enqueue_style("bootstrap-css", plugins_url("/assets/css/bootstrap.min.css", __FILE__));
        wp_enqueue_style("all-css", plugins_url("/assets/css/all.min.css", __FILE__));
        wp_enqueue_style("flaticon-css", plugins_url("/assets/css/flaticon.css", __FILE__));
        wp_enqueue_style("slick-css", plugins_url("/assets/js/lib/slick/slick.css", __FILE__));
        wp_enqueue_style("slicktheme-css", plugins_url("/assets/js/lib/slick/slick-theme.css", __FILE__));
        wp_enqueue_style("style-css", plugins_url("/assets/css/style.css", __FILE__));
        wp_enqueue_style("responsive-css", plugins_url("/assets/css/responsive.css", __FILE__));
    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have Elementor installed or activated.
     *
     * @since 1.0.0
     * @access public
     */
    public function admin_notice_missing_main_plugin() {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }

        $message = sprintf(
        /* translators: 1: Plugin name 2: Elementor */
            esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'ewebdevs-elements' ),
            '<strong>' . esc_html__( 'Ewebdevs Elements', 'ewebdevs-elements' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'ewebdevs-elements' ) . '</strong>'
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required Elementor version.
     *
     * @since 1.0.0
     * @access public
     */
    public function admin_notice_minimum_elementor_version() {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }

        $message = sprintf(
        /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'ewebdevs-elements' ),
            '<strong>' . esc_html__( 'Ewebdevs Elements', 'ewebdevs-elements' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'ewebdevs-elements' ) . '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required PHP version.
     *
     * @since 1.0.0
     * @access public
     */
    public function admin_notice_minimum_php_version() {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }

        $message = sprintf(
        /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'ewebdevs-elements' ),
            '<strong>' . esc_html__( 'Ewebdevs Elements', 'ewebdevs-elements' ) . '</strong>',
            '<strong>' . esc_html__( 'PHP', 'ewebdevs-elements' ) . '</strong>',
            self::MINIMUM_PHP_VERSION
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

}

new ewebdevselements();

<?php

namespace AxelSpringer\WP\S3;

/**
 * Class Settings
 *
 * @package AxelSpringer\WP\S3
 */
class Settings implements SettingsInterface
{
    /**
     * 
     */
    public $page;
    
    /**
     * 
     */
    public $page_title;
    
    /**
     * 
     */
    public $menu_title;

    /**
     * Settings Constructor
     *
     * @param string $plugin_file
     * @param null $version
     */
    function __construct( $page, $page_title = null, $menu_title = null )
    {
        $this->page = $page;
        $this->page_title = $page_title;
        $this->menu_title = $menu_title;

        // call to hooks
        $this->add_actions();
        $this->add_filters();

        // add_action( 'admin_init', array( &$this, 'register_settings' ) );
		// add_action( 'admin_notices', array( &$this, 'admin_notices' ) );
        // add_action( 'admin_enqueue_scripts',array( &$this, 'admin_scripts' ) );
    }

    /**
     * 
     */
    public function add_actions()
    {
        add_action( 'admin_menu', array( &$this, 'add_options_page' ) );
    }

    /**
     * 
     */
    public function add_filters()
    {
        // noop
    }
    
    /**
     * 
     */
    public function add_options_page()
    {
        $settings_page = add_options_page(
            __( $this->page_title, __PLUGIN__::TEXT_DOMAIN ),
            __( $this->menu_title, __PLUGIN__::TEXT_DOMAIN ),
            'manage_options',
            $this->page,
            array( &$this, 'settings_page' )
        );
    }

    /**
     * 
     */
    public function register_settings()
    {

    }

    /**
     * 
     */
    public function admin_notices()
    {

    }

    /**
     * 
     */
    public function admin_enqueue_scripts()
    {

    }

    /**
     * noop
     */
    protected function __clone()
    {

    }
}
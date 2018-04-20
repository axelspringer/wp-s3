<?php

namespace AxelSpringer\WP\S3;

use AxelSpringer\WP\S3\__PLUGIN__;

/**
 * Class Plugin
 *
 * @package AxelSpringer\WP\S3
 */
class Plugin
{
    /**
     * WPS3 slug
     * 
     * @var string
     */
    static $slug;

    /**
     * WPS3 plugin file
     *
     * @var string
     */
    public $plugin_file;

    /**
     * WPS3 version
     *
     * @var string
     */
    public $version;

    /**
     * WPS3 settings page
     * 
     * @var Settings
     */
    public $settings;

    /**
     * WPS3 constructor
     *
     * @param string $version
     * @param null $plugin_file
     */
    public function __construct( string $slug, $version = null, string $plugin_file )
    {
        $this->plugin_file = $plugin_file;
        $this->version = $version;
        $this->slug = $slug;

        $this->init();
    }

    /**
     * Initializes WPS3
     */
    public function init()
    {
        // settings page
        $settings = new Settings(
            __PLUGIN__::SETTINGS_PAGE,
            __TRANSLATE__::SETTINGS_PAGE_TITLE,
            __TRANSLATE__::SETTINGS_MENU_TITLE
        );

        return;
    }

    /**
     * Activates the WPS3 plugin
     *
     * @return bool
     */
    public static function activation()
    {
        $setup = new Setup();
        $success = $setup->update_version();

        return $success;
    }

    /**
     * Deactivates the WPS3 plugin
     *
     * @return void
     */
    public static function deactivation()
    {
        return;
    }
}
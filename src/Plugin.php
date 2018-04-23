<?php

namespace AxelSpringer\WP\S3;

use AxelSpringer\WP\Bootstrap\Plugin\AbstractPlugin;
use Aws\Credentials\CredentialProvider;

/**
 * Class Plugin
 *
 * @package AxelSpringer\WP\S3
 */
class Plugin extends AbstractPlugin
{
    /**
     * Client
     *
     * @var Client
     */
    public $client;

    /**
     * Filter
     *
     * @var Filter
     */
    public $filter;

    /**
     * Filter
     *
     * @var Actions
     */
    public $actions;


    /**
     * Initializes the plugin
     */
    public function init()
    {
        // load options
        $this->setup->load_options( 'AxelSpringer\WP\S3\__OPTION__' );
        $this->settings = new Settings(
            __( __TRANSLATE__::SETTINGS_PAGE_TITLE ),
            __( __TRANSLATE__::SETTINGS_MENU_TITLE ),
            __PLUGIN__::SETTINGS_PAGE,
            __PLUGIN__::SETTINGS_PERMISSION,
            $this->setup->version
        );

        // use default provider
        $provider = CredentialProvider::defaultProvider();

        // new S3 client
        $this->client   = new Client( $this->setup->options, $provider );
        $this->filters  = new Filters( $this->client );
        $this->actions  = new Actions( $this->client );
    }

    /**
     * Activates the Bootstrap plugin
     *
     * @return bool
     */
    public static function activation()
    {
        // noop
		return true;
    }

    /**
     * Do actions after init
     */
    public function after_init()
    {
        // noop
    }

    /**
     * Deactivates the Bootstrap plugin
     *
     * @return bool
     */
    public static function deactivation()
    {
        // noop
		return true;
    }

    /**
     * Loads the required WP hooks
     *
     * @return
     */
    public function load_hooks()
    {
        // $filters =
    }

    /**
     * Enqueue required scripts
     *
     * @return
     */
    public function enqueue_scripts()
    {

    }

    /**
     * Enqueue shared styles and scripts
     *
     * @return
     */
    public function enqueue_admin_scripts()
    {

	}
}

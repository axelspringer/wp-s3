<?php

namespace AxelSpringer\WP\S3;

use AxelSpringer\WP\Bootstrap\Settings\AbstractSettings;
use AxelSpringer\WP\Bootstrap\Settings\Page;
use AxelSpringer\WP\Bootstrap\Settings\Field;
use AxelSpringer\WP\Bootstrap\Settings\Section;

/**
 * Class Settings
 *
 * @package AxelSpringer\WP\Bootstrap
 */
class Settings extends AbstractSettings {

    /**
     * Loading the settings for the plugin
     */
    public function load_settings()
    {
        $args = array(
            'id'			  => 'wps3_general',
            'title'			  => __( __TRANSLATE__::SETTINGS_SECTION_GENERAL, __PLUGIN__::TEXT_DOMAIN ),
            'page'			  => $this->page,
            'description'	  => '',
        );
        $general = new Section( $args );

        $args = array(
            'id'	        => 'wps3_endpoint',
            'title'		    => 'Endpoint',
            'page'			=> $this->page,
            'section'		=> 'wps3_general',
            'description'   => 'The url to bucket (e.g. https://example.s3.amazonaws.com)',
            'type'		    => 'text', // text, textarea, password, checkbox
            'multi'		    => false,
            'option_group'	=> $this->page
        );
        $endpoint = new Field( $args );

        $args = array(
            'id'	        => 'wps3_bucket',
            'title'		    => 'Bucket',
            'page'			=> $this->page,
            'section'		=> 'wps3_general',
            'description'   => 'The url of the bucket (example)',
            'type'		    => 'text', // text, textarea, password, checkbox
            'multi'		    => false,
            'option_group'	=> $this->page
        );
        $endpoint = new Field( $args );

        $args = array(
            'id'	        => 'wps3_region',
            'title'		    => 'Region',
            'page'			=> $this->page,
            'section'		=> 'wps3_general',
            'description'   => '',
            'type'		    => 'text', // text, textarea, password, checkbox
            'multi'		    => false,
            'option_group'	=> $this->page
        );
        $region = new Field( $args );

        $args = array(
            'id'			  => 'wps3_credentials',
            'title'			  => __( __TRANSLATE__::SETTINGS_SECTION_CREDENTIALS, __PLUGIN__::TEXT_DOMAIN ),
            'page'			  => $this->page,
            'description'	  => '',
        );
        $credentials = new Section( $args );

        $args = array(
            'id'	        => 'wps3_access_key',
            'title'		    => 'Access Key',
            'page'			=> $this->page,
            'section'		=> 'wps3_credentials',
            'description'   => '',
            'type'		    => 'text', // text, textarea, password, checkbox
            'multi'		    => false,
            'option_group'	=> $this->page
        );
        $access_key = new Field( $args );

        $args = array(
            'id'	        => 'wps3_secret_access_key',
            'title'		    => 'Secret Access Key',
            'page'			=> $this->page,
            'section'		=> 'wps3_credentials',
            'description'   => '',
            'type'		    => 'text', // text, textarea, password, checkbox
            'multi'		    => false,
            'option_group'	=> $this->page
        );
        $secret_access_key = new Field( $args );

        $args = array(
            'id'			  => 'wps3_advanced',
            'title'			  => __( __TRANSLATE__::SETTINGS_SECTION_ADVANCED, __PLUGIN__::TEXT_DOMAIN ),
            'page'			  => $this->page,
            'description'	  => '',
        );
        $advanced = new Section( $args );

        $args = array(
            'id'	        => 'wps3_credentials_cache',
            'title'		    => 'Credentials Cache',
            'page'			=> $this->page,
            'section'		=> 'wps3_advanced',
            'description'   => '',
            'type'		    => 'checkbox', // text, textarea, password, checkbox
            'multi'		    => false,
            'option_group'	=> $this->page
        );
        $credentials_cache = new Field( $args );

        $args = array(
            'id'	        => 'wps3_unique_filename',
            'title'		    => 'Unique Filename',
            'page'			=> $this->page,
            'section'		=> 'wps3_advanced',
            'description'   => '',
            'type'		    => 'checkbox', // text, textarea, password, checkbox
            'multi'		    => false,
            'option_group'	=> $this->page
        );
        $unique_filename = new Field( $args );
    }
}

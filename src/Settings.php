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
            'id'	        => 'wps3_bucket',
            'title'		    => 'Bucket',
            'page'			=> $this->page,
            'section'		=> 'wps3_general',
            'description'   => '',
            'type'		    => 'text', // text, textarea, password, checkbox
            'multi'		    => false,
            'option_group'	=> $this->page
        );
        $general_bucket = new Field( $args );

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
            'id'	        => 'wps3_credentials_cache',
            'title'		    => 'Credentials Cache',
            'page'			=> $this->page,
            'section'		=> 'wps3_general',
            'description'   => '',
            'type'		    => 'checkbox', // text, textarea, password, checkbox
            'multi'		    => false,
            'option_group'	=> $this->page
        );
        $credentials_cache = new Field( $args );
    }
}

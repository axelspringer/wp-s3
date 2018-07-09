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
            'title'			  => __( Translate::SETTINGS_SECTION_GENERAL, Config::TEXT_DOMAIN ),
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
            'option_group'	=> $this->page,
            'disabled'      => !!getenv( 'WPS3_ENDPOINT' )
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
            'option_group'	=> $this->page,
            'disabled'      => !!getenv( 'WPS3_BUCKET' )
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
            'option_group'	=> $this->page,
            'disabled'      => !!getenv( 'WPS3_REGION' )
        );
        $region = new Field( $args );

        $args = array(
            'id'			  => 'wps3_credentials',
            'title'			  => __( Translate::SETTINGS_SECTION_CREDENTIALS, Config::TEXT_DOMAIN ),
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
            'option_group'	=> $this->page,
            'disabled'      => !!getenv( 'WPS3_ACCESS_KEY' )
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
            'option_group'	=> $this->page,
            'disabled'      => !!getenv( 'WPS3_SECRET_ACCESS_KEY' )
        );
        $secret_access_key = new Field( $args );

        $args = array(
            'id'			  => 'wps3_metadata',
            'title'			  => __( Translate::SETTINGS_SECTION_METADATA, Config::TEXT_DOMAIN ),
            'page'			  => $this->page,
            'description'	  => '',
        );
        $metadata = new Section( $args );

        $args = array(
            'id'	        => 'wps3_metadata_imagesizes',
            'title'		    => 'Image Sizes',
            'page'			=> $this->page,
            'section'		=> 'wps3_metadata',
            'description'   => 'Adds image size to attachment',
            'type'		    => 'checkbox', // text, textarea, password, checkbox
            'multi'		    => false,
            'option_group'	=> $this->page
        );
        $imagesizes = new Field( $args );

        $args = array(
            'id'	        => 'wps3_metadata_cache_control',
            'title'		    => 'Cache Control',
            'page'			=> $this->page,
            'section'		=> 'wps3_metadata',
            'description'   => 'Sets the CacheControl Header on S3',
            'type'		    => 'text', // text, textarea, password, checkbox
            'multi'		    => false,
            'option_group'	=> $this->page
        );
        $cachecontrol = new Field( $args );

        $args = array(
            'id'			  => 'wps3_advanced',
            'title'			  => __( Translate::SETTINGS_SECTION_ADVANCED, Config::TEXT_DOMAIN ),
            'page'			  => $this->page,
            'description'	  => '',
        );
        $advanced = new Section( $args );

        $args = array(
            'id'	        => 'wps3_endpoint_replace',
            'title'		    => 'Replace S3 Endpoint',
            'page'			=> $this->page,
            'section'		=> 'wps3_advanced',
            'description'   => 'This allows to overwrite the s3 endpoint url.',
            'type'		    => 'checkbox', // text, textarea, password, checkbox
            'multi'		    => false,
            'option_group'	=> $this->page
        );
        $enable_s3_replace = new Field( $args );

        $args = array(
            'id'	        => 'wps3_endpoint_replace_url',
            'title'		    => 'Replace S3 Endpoint URL',
            'page'			=> $this->page,
            'section'		=> 'wps3_advanced',
            'description'   => 'The url that is used to replace the endpoint',
            'type'		    => 'text', // text, textarea, password, checkbox
            'multi'		    => false,
            'option_group'	=> $this->page
        );
        $enable_s3_replace_url = new Field( $args );

        $args = array(
            'id'	        => 'wps3_filter_attachments',
            'title'		    => 'Filter Attachments',
            'page'			=> $this->page,
            'section'		=> 'wps3_advanced',
            'description'   => 'Filters the attachment URL',
            'type'		    => 'checkbox', // text, textarea, password, checkbox
            'multi'		    => false,
            'option_group'	=> $this->page
        );
        $filter_attachments = new Field( $args );

        $args = array(
            'id'	        => 'wps3_credentials_cache',
            'title'		    => 'Credentials Cache',
            'page'			=> $this->page,
            'section'		=> 'wps3_advanced',
            'description'   => 'Caches the EC2 Metadata credentials',
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
            'description'   => 'Generates unique filenames',
            'type'		    => 'checkbox', // text, textarea, password, checkbox
            'multi'		    => false,
            'option_group'	=> $this->page
        );
        $unique_filename = new Field( $args );
    }
}

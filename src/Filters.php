<?php

namespace AxelSpringer\WP\S3;

/**
 * Filters Class
 *
 * @package AxelSpringer\WP\S3
 */
class Filters
{
    /**
     * Client
     *
     * @var client
     */
    private $client;

     /**
     * Client constructor
     *
     */
    public function __construct( Client &$client )
    {
        // use initialized client
        $this->client = $client;

        // register filters
        add_filter( 'upload_dir', array( &$this, 'filter_upload_dir' ) );
        // add_filter( 'pre_option_uploads_use_yearmonth_folders', '__return_null' );
        // add_filter( 'plupload_init', array( &$this, 'plupload_init' ) );
        // add_filter( 'wp_handle_upload ', 'custom_upload_filter' );
        // add_filter( 'wp_handle_upload_prefilter', array( &$this, 'filter_upload_prefilter' ) );
    }

    /**
     *
     */
    public function filter_upload_dir( $param )
    {
        $param = array(
            'path'    => $this->client->get_s3path(),
            'url'     => $this->client->get_url(),
            'basedir' => $this->client->get_s3path(),
            'baseurl' => $this->client->get_url(),
            'subdir'  => '',
            'error'   => false
        );
        return $param;
    }

    /**
     *
     */
    public function filter_upload_prefilter()
    {

    }

    /**
     * noop
     */
    protected function __clone()
    {

    }
}

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
     * Unique files
     *
     */
    private $unique_files = [];

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
        add_filter( 'wp_handle_upload ', 'custom_upload_filter' );
        add_filter( 'wp_handle_upload_prefilter', array( &$this, 'filter_upload_prefilter' ) );
    }

    /**
     * Filter uploads
     *
     * @param array $param
     */
    public function filter_upload_dir( $param )
    {
        $param = array(
            'path'    => $this->client->get_s3path( $param[ 'subdir' ] ),
            'url'     => $this->client->get_url( $param[ 'subdir' ] ),
            'basedir' => $this->client->get_s3path(),
            'baseurl' => $this->client->get_url(),
            'subdir'  => '',
            'error'   => false
        );
        return $param;
    }

    /**
     * Prefilter file uploads
     *
     * @param array $file
     * @return array $file
     */
    public function filter_upload_prefilter( $file )
    {
        if ( ! $this->client->options[ 'wps3_unique_filename' ] )
            return $file;

        $file_info  = pathinfo( $file['name'] );
        $file_hash  = crc32( json_encode( array( $file_info['basename'], current_time( 'mysql' ) ) ) );
        $file_time  = date( 'Ymd', current_time( 'timestamp', 0 ) );
        $file_ext   = $file_info['extension'];
        // set filename
        $file['name'] = "$file_time-$file_hash.$file_ext";

        return $file;
    }

    /**
     * noop
     */
    protected function __clone()
    {

    }
}

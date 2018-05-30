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
        add_filter( 'intermediate_image_sizes_advanced', array( &$this, 'intermediate_image_sizes_advanced' ), 99, 1 );
        add_filter( 'wp_generate_attachment_metadata', array( &$this, 'wp_generate_attachment_metadata' ), 99, 2 );
    }

    /**
     * Generate image attachments
     */
    public function wp_generate_attachment_metadata( $metadata, $attachment_id )
    {
        if ( false === $this->client->options['wps3_metadata_imagesizes']) {
            return $metadata;
        }

        $sizes = $this->get_all_image_sizes();
        $pathinfo = pathinfo( $metadata['file'] );

        foreach( $sizes as $size => $data) {
            $new_size = array(
                'file'      => $pathinfo['filename'] . '-' . $data['width'] . 'x' . $data['height'], // not so nice
                'width'     => $data['width'],
                'height'    => $data['height'],
                'mime-type' => 'image/jpeg'
            );

            $metadata['sizes'][$size] = $new_size;
        }

        return $metadata;
    }

    /**
     * Filter image sizes for upload
     */
    public function intermediate_image_sizes_advanced( $sizes )
    {
        if ( false === $this->client->options['wps3_metadata_imagesizes']) {
            return $sizes;
        }

        return []; // do not generate any
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
     * Get all the registered image sizes along with their dimensions
     *
     * @global array $_wp_additional_image_sizes
     *
     * @link http://core.trac.wordpress.org/ticket/18947 Reference ticket
     *
     * @return array $image_sizes The image sizes
     */
    public function get_all_image_sizes()
    {
        global $_wp_additional_image_sizes;

        $default_image_sizes = get_intermediate_image_sizes();

        foreach ( $default_image_sizes as $size ) {
            $image_sizes[ $size ][ 'width' ] = intval( get_option( "{$size}_size_w" ) );
            $image_sizes[ $size ][ 'height' ] = intval( get_option( "{$size}_size_h" ) );
            $image_sizes[ $size ][ 'crop' ] = get_option( "{$size}_crop" ) ? get_option( "{$size}_crop" ) : false;
        }

        if ( isset( $_wp_additional_image_sizes ) && count( $_wp_additional_image_sizes ) ) {
            $image_sizes = array_merge( $image_sizes, $_wp_additional_image_sizes );
        }

        return $image_sizes;
    }

    /**
     * noop
     */
    protected function __clone()
    {

    }
}

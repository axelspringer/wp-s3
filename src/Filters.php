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
        add_filter( 'wp_handle_upload', array( &$this, 'wp_handle_upload' ) );
        add_filter( 'wp_handle_upload_prefilter', array( &$this, 'filter_upload_prefilter' ) );
        add_filter( 'intermediate_image_sizes_advanced', array( &$this, 'intermediate_image_sizes_advanced' ), 99, 2 );
        add_filter( 'wp_generate_attachment_metadata', array( &$this, 'wp_generate_attachment_metadata' ), 99, 2 );
        add_filter( 'pre_move_uploaded_file', array( &$this, 'pre_move_uploaded_file' ), 99, 4 );
        add_filter( 'wp_get_attachment_url', array( &$this, 'filter_endpoint_url' ), 99 );
        add_filter( 'the_content', array( &$this, 'filter_endpoint_url' ), 99 );
    }

    /**
     * Filter uploaded data
     */
    public function wp_handle_upload( $upload )
    {
        $this->client->set_metadata();

        return $upload;
    }

    /**
     *
     */
    public function pre_move_uploaded_file( $move_new_file, $file, $new_file, $type )
    {
        $moved_file = pathinfo( $new_file );
        $additional_sizes = $this->get_additional_sizes( $moved_file['basename'] );
        $add_metadata = true;

        foreach( $additional_sizes as $size => $data ) {
            if ( $data['file'] === $moved_file['basename'] ) {
                $add_metadata = false;
            }
        }

        $this->set_metadata_sizes( $additional_sizes );

        return $move_new_file;
    }

    /**
     * Add metadata for file sizes
     */
    public function set_metadata_sizes( $sizes = array(), $prefix = 'wp-size' )
    {
        $metadata = array();

        if ( empty( $this->client->options['wps3_metadata_imagesizes']) ) return;

        foreach( $sizes as $size => $data ) {
            $key = implode( '-', array( $prefix, $size) );
            $metadata[$key] = implode(',', array( $data['width'], $data['height'] ) );
        }

        $this->client->set_metadata( $metadata );
    }

    /**
     * Generate image attachments
     */
    public function wp_generate_attachment_metadata( $metadata, $attachment_id )
    {
        if ( empty( $this->client->options['wps3_metadata_imagesizes']) ) return $metadata;

        $sizes = $this->get_additional_sizes( $metadata['file'] );
        $metadata['sizes'] = array_merge( $metadata['sizes'], $sizes );

        return $metadata;
    }

    /**
     * Get sizes for filename
     *
     */
    public function get_additional_sizes( $file, $type = 'image/jpeg' )
    {
        global $_wp_additional_image_sizes;
        $file = pathinfo( $file ) ;
        $sizes = [];

        if ( ! is_array( $_wp_additional_image_sizes ) ||
            empty( $_wp_additional_image_sizes ) ) {
            return $sizes;
        }

        foreach( $_wp_additional_image_sizes as $size => $data ) {
            $new_size = array(
                'file'      => $file['filename'] . '-' . $data['width'] . 'x' . $data['height'] . '.' . $file['extension'], // not so nice
                'width'     => $data['width'],
                'height'    => $data['height'],
                'mime-type' => $type
            );

            $sizes[$size] = $new_size;
        }

        return $sizes;
    }

    /**
     * Filter image sizes for upload
     */
    public function intermediate_image_sizes_advanced( $sizes, $metadata )
    {
        if ( empty ( $this->client->options['wps3_metadata_imagesizes']) ) return $sizes;

        global $_wp_additional_image_sizes;

        return array_diff_assoc( $sizes, $_wp_additional_image_sizes );
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
     * Filter endpoint string to new url
     *
     * @param string $url
     * @return string $url
     */
    public function filter_endpoint_url( $str ) {
        if ( ! $this->client->options[ 'wps3_endpoint_replace' ]
        || empty( $this->client->options[ 'wps3_endpoint_replace_url' ] ) ){
            return $str;
        }

        if ( empty( $this->client->options[ 'wps3_endpoint' ] ) ) {
            return $str;
        }

        return str_replace( $this->client->options[ 'wps3_endpoint' ], $this->client->options[ 'wps3_endpoint_replace_url' ], $str );
    }

    /**
     * Prefilter file uploads
     *
     * @param array $file
     * @return array $file
     */
    public function filter_upload_prefilter( $file )
    {
        if ( empty( $this->client->options[ 'wps3_unique_filename' ] ) ) return $file;

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

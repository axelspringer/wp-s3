<?php

namespace AxelSpringer\WP\S3;

/**
 * Filters Class
 *
 * @package AxelSpringer\WP\S3
 */
class Actions
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

       // add_action( 'delete_attachment', array( &$this, 'delete_attachment' ) );
       add_action( 'wp_delete_file', array( &$this, 'wp_delete_file' ) );
       add_action( 'after_setup_theme', array( &$this, 'wp_file_sizes' ) );
    }

    /**
     * Add metadata for file sizes
     */
    public function wp_file_sizes()
    {
        $metadata = array();

        if ( false === $this->client->options['wps3_metadata_imagesizes']) {
            return;
        }

        foreach( $this->get_all_image_sizes() as $size => $data ) {
            $metadata[$size] = implode(',', array( $data['width'], $data['height'] ) );
        }

        $this->client->set_metadata( $metadata );
    }

    /**
     * Delete attachment
     *
     * @param int $post_id
     */
    public function wp_delete_file( $file )
    {
        @unlink( $file ); // force unlink for unlink
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

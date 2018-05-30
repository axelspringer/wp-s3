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
     * noop
     */
    protected function __clone()
    {

    }
}

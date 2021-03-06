<?php

namespace AxelSpringer\WP\S3;

use Aws\Credentials\CredentialProvider;
use Aws\DoctrineCacheAdapter;
use Aws\S3\S3Client;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\Common\Cache\ApcuCache;

/**
 * Class Client
 *
 *
 * @package AxelSpringer\WP\S3
 */
class Client implements ClientInterface
{

    /**
     * Client to access S3
     *
     * @var S3Client
     */
    private $client;

    /**
     * Credentials provider (e.g. ECS Task)
     *
     * @var CredentialProvider
     */
    private $provider;

    /**
     * Credentials cache
     *
     * @var DoctrineCacheAdapter
     */
    private $cache_adapter;

    /**
     * Options
     *
     * @var array
     */
    public $options;

    /**
     * Uri
     */
    public $uri;

    /**
     * Args
     */
    public $args = [];

    /**
     * Stream
     */
    public $stream = 's3';

    /**
     * Client constructor
     *
     */
    public function __construct( &$options, $provider = null, $version = '2006-03-01' )
    {
        // map options
        $this->options = $options;

        if ( ! is_null ( $provider ) ) // here you can use any
            $this->provider = $provider;

        if ( $this->options[ 'wps3_credentials_cache' ] ) // use cache adapter
            $this->cache_adapter = new DoctrineCacheAdapter( new ApcuCache );

        // client args
        $args = [
            'region'            => $options[ 'wps3_region' ],
            'credentials'       => $this->provider,
            'version'           => $version,
            'use_path_style_endpoint' => true
            // 'credentials'       => ! $this->options[ 'wps3_credentials_cache' ] ? $this->provider : $this->cache_adapter
        ];

        // set client args
        $this->set_args( $args );

        // new client
        $this->set_client ( new S3Client( $this->args ) );
    }

    /**
     * Set the client
     */
    public function set_client( $client, $stream = 's3', $seekable = true, $acl = ACL::PUBLIC_READ )
    {
        $this->client = $client;
        $this->stream = $stream;
        $this->client->registerStreamWrapper();

        // setup stream context
        stream_context_set_option( stream_context_get_default(), $stream, Context::ACL, $acl );
        stream_context_set_option( stream_context_get_default(), $stream, 'seekable', $seekable );

        // set cache control
        $this->set_context_option( Context::CACHE_CONTROL, $this->options[ 'wps3_metadata_cache_control' ] );
    }

    /**
     * Set metadata on stream context
     *
     * If called without parameter, this should reset metadata
     *
     */
    public function set_metadata( $metadata = array() )
    {
        if ( ! $this->client || ! $this->stream ) {
            return;
        }

        // set metadata on context
        $this->set_context_option( Context::METADATA, $metadata );
    }

    /**
     * Public set context
     *
     * This sets context information
     */
    public function set_context_option( $option = '', $value = [] )
    {
        if ( ! $this->client || ! $this->stream || empty( $option ) ) {
            return;
        }

        stream_context_set_option( stream_context_get_default(), $this->stream, $option, $value );
    }

    /**
     * Set URI
     *
     * @param string $uri
     */
    public function set_uri( string $uri )
    {
        $this->uri = $uri;
    }

    /**
     * Set args
     */
    public function set_args( array $args )
    {
        $this->args = array_merge( $this->args, $args );
    }

    /**
     * Get the client
     */
    public function get_client( )
    {
        return $this->client;
    }

    /**
     *
     */
    public function get_s3path( $subdir = "" )
    {
        $bucket = $this->options[ 'wps3_bucket' ];
        return "s3://$bucket$subdir";
    }

    /**
     * Get the url
     */
    public function get_url( $subdir = "" )
    {
        // todo: use other domain
        $endpoint = $this->options[ 'wps3_endpoint' ];
        return "$endpoint$subdir";
    }

    /**
     * Get the used credentials
     */
    public function get_credentials()
    {
        // noop
    }

    /**
     * noop
     */
    protected function __clone()
    {

    }
}

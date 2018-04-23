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
     *
     */
    private $options;

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

        // new client
        $this->client = new S3Client( [
            'profile' => 'default',
            'region'            => $options[ 'wps3_region' ],
            'credentials'       => $this->provider,
            'version'           => $version,
            // 'credentials'       => ! $this->options[ 'wps3_credentials_cache' ] ? $this->provider : $this->cache_adapter
        ] );

        $this->client->registerStreamWrapper();
    }

    /**
     * Set the client
     */
    public function set_client( $client )
    {
        $this->client = $client;
    }

    /**
     * Get the client
     */
    public function get_client()
    {
        return $this->client;
    }

    /**
     *
     */
    public function get_s3path()
    {
        $bucket = $this->options['wps3_bucket'];
        return "s3://$bucket";
    }

    /**
     * Get the url
     */
    public function get_url()
    {
        return "https://axelspringer-prod-mango-static-master.s3.amazonaws.com";
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

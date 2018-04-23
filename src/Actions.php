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
    }

    /**
     * noop
     */
    protected function __clone()
    {

    }
}

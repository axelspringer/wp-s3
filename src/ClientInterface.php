<?php

namespace AxelSpringer\WP\S3;

interface ClientInterface
{
    public function get_client();
    public function get_credentials();
}
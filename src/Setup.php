<?php

namespace AxelSpringer\WP\S3;

use AxelSpringer\WP\S3\__PLUGIN__;

/**
 * Class Setup
 *
 * @package AxelSpringer\WP\S3
 */
class Setup
{
    /**
     * Setup constructor
     */
    public function __construct()
    {
    }

    /**
     * Updates the WP S3 version in the WP options
     *
     * @return bool
     */
    public function update_version() {
        $option = __PLUGIN__::SLUG . '_version';
        $old_version = get_option( $option);

        if ( false === $old_version ||
            version_compare( $old_version, WPS3_VERSION, '<' ) ) {
            return update_option( $option, WPS3_VERSION );
        }

        return true;
    }

    /**
     * noop
     */
    protected function __clone()
    {
    }
}

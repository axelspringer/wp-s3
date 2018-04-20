<?php

/**
 * Plugin Name: WordPress S3
 * Plugin URI: http://www.axelspringer.de
 * Description: A companion WordPress Plugin for S3.
 * Version: 1.0.0
 * Author: Axel Springer SE
 * Author URI: http://www.axelspringer.de
 * License: Apache-2.0
 */

defined( 'ABSPATH' ) || exit;

// make sure we don't expose any info if called directly
if ( ! function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

// respect composer autoload
$vendor_autoload_file =  __DIR__ . '/vendor/autoload.php';
if ( file_exists( $vendor_autoload_file ) ) {
	$loader = require_once $vendor_autoload_file;
	$loader->addPsr4( 'AxelSpringer\\WP\\S3\\', __DIR__ . '/src' );
}

use \AxelSpringer\WP\S3\__WP__;
use \AxelSpringer\WP\S3\__PLUGIN__;
use \AxelSpringer\WP\S3\Plugin;

// bootstrap
if ( ! defined( __WP__::VERSION ) )
	define( __WP__::VERSION, __PLUGIN__::VERSION );
  
if ( ! defined( __WP__::URL ) )
	define( __WP__::URL, plugin_dir_url( __FILE__ ) );

if ( ! defined( __WP__::SLUG ) )
	define( __WP__::SLUG, __PLUGIN__::SLUG );

// activation
register_activation_hook( __FILE__, '\AxelSpringer\WP\S3\Plugin::activation' );

// deactivation
register_deactivation_hook( __FILE__, '\AxelSpringer\WP\S3\Plugin::deactivation' );

// register plugin
global $wps3;
$wps3 = new Plugin( WPS3_SLUG, WPS3_VERSION, __FILE__ );

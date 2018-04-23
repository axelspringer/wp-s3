<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              	https://github.com/axelspringer/wp-s3
 * @since             	1.0.0-dev
 * @package           	AxelSpringer
 * @author            	Axel Springer SE
 *
 * @wordpress-plugin
 * Plugin Name: 		WordPress S3
 * Plugin URI: 			http://www.axelspringer.de
 * Description: 		A companion WordPress Plugin for S3.
 * Version: 			1.0.0-dev
 * Author: 				Axel Springer SE
 * Author 				URI: http://www.axelspringer.de
 * License: 			Apache-2.0
 */

defined( 'ABSPATH' ) || exit;

// make sure we don't expose any info if called directly
if ( ! function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

// respect composer autoload
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	$loader = require_once __DIR__ . '/vendor/autoload.php';
	$loader->addPsr4( 'AxelSpringer\\WP\\S3\\', __DIR__ . '/src' );
}

// if not composer, do autoloading
if ( ! class_exists( 'AxelSpringer\WP\S3\Plugin' ) ) {
    include_once __DIR__ . '/autoloader.php';
}

use \AxelSpringer\WP\S3\__WP__ as WP;
use \AxelSpringer\WP\S3\__PLUGIN__ as Plugin;
use \AxelSpringer\WP\S3\Plugin as S3;

// bootstrap
if ( ! defined( WP::VERSION ) )
	define( WP::VERSION, Plugin::VERSION );

if ( ! defined( WP::URL ) )
	define( WP::URL, plugin_dir_url( __FILE__ ) );

if ( ! defined( WP::SLUG ) )
    define( WP::SLUG, Plugin::SLUG );

// activation
register_activation_hook( __FILE__, '\AxelSpringer\WP\S3\Plugin::activation' );

// deactivation
register_deactivation_hook( __FILE__, '\AxelSpringer\WP\S3\Plugin::deactivation' );

// run
global $wps3; // this bootstraps the plugin, and provides a global accessible helper
$wps3 = new S3( WPS3_SLUG, WPS3_VERSION, __FILE__ );

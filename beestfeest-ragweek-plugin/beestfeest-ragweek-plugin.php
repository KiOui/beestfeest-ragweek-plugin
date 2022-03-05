<?php
/**
 * Plugin Name: BeestFeest RAGweek Plugin
 * Description: A WordPress plugin for the BeestFeest RAGweek edition
 * Plugin URI: https://github.com/KiOui/beestfeest-ragweek-plugin
 * Version: 0.0.2
 * Author: Lars van Rhijn
 * Author URI: https://larsvanrhijn.nl/
 * Text Domain: beestfeest-ragweek
 * Domain Path: /languages/
 *
 * @package beestfeest-ragweek-plugin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'BFRW_PLUGIN_FILE' ) ) {
	define( 'BFRW_PLUGIN_FILE', __FILE__ );
}
if ( ! defined( 'BFRW_PLUGIN_URI' ) ) {
	define( 'BFRW_PLUGIN_URI', plugin_dir_url( __FILE__ ) );
}

include_once dirname( __FILE__ ) . '/includes/class-bfrwcore.php';

$GLOBALS['BFRWCore'] = BFRWCore::instance();

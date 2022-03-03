<?php
/**
 * BeestFeest RAGweek plugin Core class
 *
 * @package beestfeest-ragweek-plugin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'BFRWCore' ) ) {
	/**
	 * BeestFeest RAGweek Core class.
	 *
	 * @class BFRWCore
	 */
	class BFRWCore {
		/**
		 * The single instance of the class.
		 *
		 * @var BFRWCore|null
		 */
		protected static ?BFRWCore $_instance = null;

		/**
		 * BeestFeest RAGweek Core.
		 *
		 * Uses the Singleton pattern to load 1 instance of this class at maximum.
		 *
		 * @static
		 * @return BFRWCore
		 */
		public static function instance(): BFRWCore {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * Constructor.
		 */
		private function __construct() {
			$this->define_constants();
			$this->init_hooks();
			$this->actions_and_filters();
		}

		/**
		 * Initialise BeestFeest RAGweek Core.
		 */
		public function init() {
			$this->initialise_localisation();
			do_action( 'beestfeest_ragweek_init' );
		}

		/**
		 * Initialise the localisation of the plugin.
		 */
		private function initialise_localisation() {
			load_plugin_textdomain( 'beestfeest-ragweek', false, plugin_basename( dirname( BFRW_PLUGIN_FILE ) ) . '/languages/' );
		}

		/**
		 * Define constants of the plugin.
		 */
		private function define_constants() {
			$this->define( 'BFRW_ABSPATH', dirname( BFRW_PLUGIN_FILE ) . '/' );
			$this->define( 'BFRW_FULLNAME', 'beestfeest-ragweek' );
		}

		/**
		 * Define if not already set.
		 *
		 * @param string $name the name.
		 * @param string $value the value.
		 */
		private static function define( string $name, string $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

		/**
		 * Initialise activation and deactivation hooks.
		 */
		private function init_hooks() {
			register_activation_hook( BFRW_PLUGIN_FILE, array( $this, 'activation' ) );
			register_deactivation_hook( BFRW_PLUGIN_FILE, array( $this, 'deactivation' ) );
		}

		/**
		 * Activation hook call.
		 */
		public function activation() {
		}

		/**
		 * Deactivation hook call.
		 */
		public function deactivation() {
		}

		/**
		 * Add actions and filters.
		 */
		private function actions_and_filters() {
		}
	}
}

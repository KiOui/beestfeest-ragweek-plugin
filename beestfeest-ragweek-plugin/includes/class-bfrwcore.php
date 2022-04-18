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
		protected static $_instance = null;

		/**
		 * BeestFeest RAGweek Core.
		 *
		 * Uses the Singleton pattern to load 1 instance of this class at maximum.
		 *
		 * @static
		 * @return BFRWCore
		 */
		public static function instance() {
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
			add_role( 'bfrw_manager', __( 'RAGweek manager', 'beestfeest-ragweek' ) );
		}

		/**
		 * Deactivation hook call.
		 */
		public function deactivation() {
			remove_role( 'bfrw_manager' );
		}

		/**
		 * Add Custom Post Types.
		 */
		public function add_post_types() {
			register_post_type(
				'bfrw_requested_songs',
				array(
					'label' => __( 'Requested songs', 'beestfeest-ragweek' ),
					'labels' => array(
						'name' => __( 'Requested songs', 'beestfeest-ragweek' ),
						'singular_name' => __( 'Requested song', 'beestfeest-ragweek' ),
						'add_new' => __( 'Add New', 'beestfeest-ragweek' ),
						'add_new_item' => __( 'Add New Requested song', 'beestfeest-ragweek' ),
						'edit_item' => __( 'Edit Requested song', 'beestfeest-ragweek' ),
						'new_item' => __( 'New Requested song', 'beestfeest-ragweek' ),
						'view_item' => __( 'View Requested song', 'beestfeest-ragweek' ),
						'view_items' => __( 'View Requested songs', 'beestfeest-ragweek' ),
						'search_items' => __( 'Search Requested songs', 'beestfeest-ragweek' ),
						'not_found' => __( 'No requested songs found', 'beestfeest-ragweek' ),
						'not_found_in_trash' => __( 'No requested songs found in trash', 'beestfeest-ragweek' ),
						'parent_item_colon' => __( 'Parent Requested song', 'beestfeest-ragweek' ),
						'all_items' => __( 'All Requested songs', 'beestfeest-ragweek' ),
						'archives' => __( 'Requested song Archives', 'beestfeest-ragweek' ),
						'attributes' => __( 'Requested song Attributes', 'beestfeest-ragweek' ),
						'insert_into_item' => __( 'Insert into requested song', 'beestfeest-ragweek' ),
						'uploaded_to_this_item' => __( 'Uploaded to this requested song', 'beestfeest-ragweek' ),
						'featured_image' => __( 'Featured image', 'beestfeest-ragweek' ),
						'set_featured_image' => __( 'Set featured image', 'beestfeest-ragweek' ),
						'remove_featured_image' => __( 'Remove featured image', 'beestfeest-ragweek' ),
						'use_featured_image' => __( 'Use as featured image', 'beestfeest-ragweek' ),
						'menu_name' => __( 'Requested songs', 'beestfeest-ragweek' ),
						'filter_items_list' => __( 'Filter requested songs list', 'beestfeest-ragweek' ),
						'filter_by_date' => __( 'Filter by date', 'beestfeest-ragweek' ),
						'items_list_navigation' => __( 'Requested songs list navigation', 'beestfeest-ragweek' ),
						'items_list' => __( 'Requested songs list', 'beestfeest-ragweek' ),
						'item_published' => __( 'Requested song published', 'beestfeest-ragweek' ),
						'item_published_privately' => __( 'Requested song published privately', 'beestfeest-ragweek' ),
						'item_reverted_to_draft' => __( 'Requested song reverted to draft', 'beestfeest-ragweek' ),
						'item_scheduled' => __( 'Requested song scheduled', 'beestfeest-ragweek' ),
						'item_updated' => __( 'Requested song updated', 'beestfeest-ragweek' ),
					),
					'description' => __( 'Requested song post type', 'beestfeest-ragweek' ),
					'public' => true,
					'hierarchical' => false,
					'exclude_from_search' => true,
					'publicly_queryable' => false,
					'show_ui' => true,
					'show_in_menu' => true,
					'show_in_nav_menus' => false,
					'show_in_admin_bar' => true,
					'show_in_rest' => true,
					'menu_position' => 56,
					'menu_icon' => 'dashicons-album',
					'taxonomies' => array(),
					'has_archive' => false,
					'can_export' => true,
					'delete_with_user' => false,
					'capability_type' => array( 'bfrw_manager', 'bfrw_requested_songs' ),
					'map_meta_cap' => true,
				)
			);
			remove_post_type_support( 'bfrw_requested_songs', 'editor' );
			register_post_type(
				'bfrw_notifications',
				array(
					'label' => __( 'Notifications', 'beestfeest-ragweek' ),
					'labels' => array(
						'name' => __( 'Notifications', 'beestfeest-ragweek' ),
						'singular_name' => __( 'Notification', 'beestfeest-ragweek' ),
						'add_new' => __( 'Add New', 'beestfeest-ragweek' ),
						'add_new_item' => __( 'Add New Notification', 'beestfeest-ragweek' ),
						'edit_item' => __( 'Edit Notification', 'beestfeest-ragweek' ),
						'new_item' => __( 'New Notification', 'beestfeest-ragweek' ),
						'view_item' => __( 'View Notification', 'beestfeest-ragweek' ),
						'view_items' => __( 'View Notifications', 'beestfeest-ragweek' ),
						'search_items' => __( 'Search Notifications', 'beestfeest-ragweek' ),
						'not_found' => __( 'No notifications found', 'beestfeest-ragweek' ),
						'not_found_in_trash' => __( 'No notifications found in trash', 'beestfeest-ragweek' ),
						'parent_item_colon' => __( 'Parent Notification', 'beestfeest-ragweek' ),
						'all_items' => __( 'All Notifications', 'beestfeest-ragweek' ),
						'archives' => __( 'Notification Archives', 'beestfeest-ragweek' ),
						'attributes' => __( 'Notification Attributes', 'beestfeest-ragweek' ),
						'insert_into_item' => __( 'Insert into notifications', 'beestfeest-ragweek' ),
						'uploaded_to_this_item' => __( 'Uploaded to this notification', 'beestfeest-ragweek' ),
						'featured_image' => __( 'Featured image', 'beestfeest-ragweek' ),
						'set_featured_image' => __( 'Set featured image', 'beestfeest-ragweek' ),
						'remove_featured_image' => __( 'Remove featured image', 'beestfeest-ragweek' ),
						'use_featured_image' => __( 'Use as featured image', 'beestfeest-ragweek' ),
						'menu_name' => __( 'Notifications', 'beestfeest-ragweek' ),
						'filter_items_list' => __( 'Filter notifications list', 'beestfeest-ragweek' ),
						'filter_by_date' => __( 'Filter by date', 'beestfeest-ragweek' ),
						'items_list_navigation' => __( 'Notifications list navigation', 'beestfeest-ragweek' ),
						'items_list' => __( 'Notifications list', 'beestfeest-ragweek' ),
						'item_published' => __( 'Notification published', 'beestfeest-ragweek' ),
						'item_published_privately' => __( 'Notification published privately', 'beestfeest-ragweek' ),
						'item_reverted_to_draft' => __( 'Notification reverted to draft', 'beestfeest-ragweek' ),
						'item_scheduled' => __( 'Notification scheduled', 'beestfeest-ragweek' ),
						'item_updated' => __( 'Notification updated', 'beestfeest-ragweek' ),
					),
					'description' => __( 'Notification post type', 'beestfeest-ragweek' ),
					'public' => true,
					'hierarchical' => false,
					'exclude_from_search' => true,
					'publicly_queryable' => false,
					'show_ui' => true,
					'show_in_menu' => true,
					'show_in_nav_menus' => false,
					'show_in_admin_bar' => true,
					'show_in_rest' => true,
					'menu_position' => 56,
					'menu_icon' => 'dashicons-megaphone',
					'taxonomies' => array(),
					'has_archive' => false,
					'can_export' => true,
					'delete_with_user' => false,
					'capability_type' => array( 'bfrw_manager', 'bfrw_notifications' ),
					'map_meta_cap' => true,
				)
			);
			remove_post_type_support( 'bfrw_notifications', 'editor' );
		}

		/**
		 * Add meta box support to Custom Post types.
		 */
		public function add_meta_box_support() {
			include_once BFRW_ABSPATH . '/includes/metaboxes/class-metabox.php';
			new Metabox(
				'bfrw_requested_songs_metabox',
				array(
					array(
						'label' => __( 'Requested song bid', 'beestfeest-ragweek' ),
						'desc'  => __( 'Price paid for requesting the song', 'beestfeest-ragweek' ),
						'id'    => 'bfrw_requested_song_price',
						'type'  => 'number',
						'min'   => 0,
						'step'  => 0.01,
						'required' => true,
						'default' => 0,
					),
				),
				'bfrw_requested_songs',
				__( 'Price settings' )
			);
		}

		/**
		 * Add pluggable support to functions.
		 */
		public function pluggable() {
			include_once BFRW_ABSPATH . 'includes/bfrw-functions.php';
		}

		/**
		 * Add role capabilities.
		 */
		public function add_role_capabilities() {
			foreach ( array( 'bfrw_manager', 'administrator' ) as $role_str ) {
				$role = get_role( $role_str );
				if ( isset( $role ) ) {
					$role->add_cap( 'read' );
					$role->add_cap( 'edit_bfrw_notifications' );
					$role->add_cap( 'read_bfrw_notifications' );
					$role->add_cap( 'delete_bfrw_notifications' );
					$role->add_cap( 'read_private_bfrw_notifications' );
					$role->add_cap( 'edit_others_bfrw_notifications' );
					$role->add_cap( 'publish_bfrw_notifications' );
					$role->add_cap( 'edit_published_bfrw_notifications' );
					$role->add_cap( 'delete_others_bfrw_notifications' );
					$role->add_cap( 'delete_private_bfrw_notifications' );
					$role->add_cap( 'delete_published_bfrw_notifications' );

					$role->add_cap( 'edit_bfrw_requested_songs' );
					$role->add_cap( 'read_bfrw_requested_songs' );
					$role->add_cap( 'delete_bfrw_requested_songs' );
					$role->add_cap( 'read_private_bfrw_requested_songs' );
					$role->add_cap( 'edit_others_bfrw_requested_songs' );
					$role->add_cap( 'publish_bfrw_requested_songs' );
					$role->add_cap( 'edit_published_bfrw_requested_songs' );
					$role->add_cap( 'delete_others_bfrw_requested_songs' );
					$role->add_cap( 'delete_private_bfrw_requested_songs' );
					$role->add_cap( 'delete_published_bfrw_requested_songs' );
				}
			}
		}

		/**
		 * Add custom shortcode.
		 */
		public function add_shortcode() {
			add_shortcode( 'bfrw-ragweek', 'do_ragweek_shortcode' );
		}

		/**
		 * Add actions and filters.
		 */
		private function actions_and_filters() {
			add_action( 'after_setup_theme', array( $this, 'pluggable' ) );
			add_action( 'init', array( $this, 'init' ) );
			add_action( 'init', array( $this, 'add_shortcode' ) );
			add_action( 'beestfeest_ragweek_init', array( $this, 'add_post_types' ) );
			add_action( 'beestfeest_ragweek_init', array( $this, 'add_meta_box_support' ) );
			add_action(
				'rest_api_init',
				function() {
					register_rest_field(
						'bfrw_requested_songs',
						'bfrw_requested_song_price',
						array(
							'get_callback'    => 'bfrw_get_price',
							'schema'          => array(
								'type'        => 'float',
								'description' => 'The current bid on the song.',
								'context'     => array( 'view' ),
							),
						)
					);
				}
			);
			if ( is_admin() ) {
				add_filter( 'manage_bfrw_requested_songs_posts_columns', 'bfrw_requested_songs_columns' );
				add_action( 'manage_bfrw_requested_songs_posts_custom_column', 'bfrw_requested_songs_columns_values', 10, 2 );
				add_filter( 'manage_edit-bfrw_requested_songs_sortable_columns', 'bfrw_requested_songs_sortable_columns' );
				add_action( 'pre_get_posts', 'bfrw_requested_songs_sort_column' );
				add_action( 'admin_init', array( $this, 'add_role_capabilities' ) );
			} else {
				add_filter( 'template_include', 'bfrw_override_template' );
			}
		}
	}
}

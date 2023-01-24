<?php
/**
 * BeestFeest RAGweek plugin functions
 *
 * @package beestfeest-ragweek-plugin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'bfrw_requested_songs_columns' ) ) {
	/**
	 * Update the admin columns for requested_songs post type.
	 *
	 * @param array $columns the current admin columns.
	 *
	 * @return array the admin columns with the song price added.
	 */
	function bfrw_requested_songs_columns( array $columns ): array {
		unset( $columns['date'] );
		$columns['bfrw_requested_song_price'] = __( 'Current bid', 'beestfeest-ragweek' );
		return $columns;
	}
}

if ( ! function_exists( 'bfrw_requested_songs_columns_values' ) ) {
	/**
	 * Output the column value for the requested_songs post type.
	 *
	 * @param string $column the column that is being rendered.
	 * @param int    $post_id the post ID of the post.
	 *
	 * @return void
	 */
	function bfrw_requested_songs_columns_values( string $column, int $post_id ) {
		if ( 'bfrw_requested_song_price' === $column ) {
			$current_bid = get_post_meta( $post_id, 'bfrw_requested_song_price', true );
			echo esc_html( '&euro;' . bfrw_format_price( $current_bid ) );
		}
	}
}

if ( ! function_exists( 'bfrw_requested_songs_sortable_columns' ) ) {
	/**
	 * Add the song price column as sortable for the requested_songs post type.
	 *
	 * @param array $columns the current sortable columns.
	 *
	 * @return array an array with the song price column added.
	 */
	function bfrw_requested_songs_sortable_columns( array $columns ): array {
		$columns['bfrw_requested_song_price'] = 'bfrw_requested_song_price';
		return $columns;
	}
}

if ( ! function_exists( 'bfrw_requested_songs_sort_column' ) ) {
	/**
	 * Add a sort query when the requested_songs post type when sorting is done on price.
	 *
	 * @param WP_Query $query the current sort query.
	 *
	 * @return void
	 */
	function bfrw_requested_songs_sort_column( WP_Query $query ) {
		if ( 'bfrw_requested_song_price' == $query->query_vars['orderby'] ) {
			$meta_query = array(
				array(
					'key'     => 'bfrw_requested_song_price',
				),
			);
			$query->set( 'orderby', 'meta_value_num' );
			$query->set( 'order', 'asc' == $query->query_vars['order'] ? 'ASC' : 'DESC' );
			$query->set( 'meta_query', $meta_query );
		}
	}
}

if ( ! function_exists( 'bfrw_format_price' ) ) {
	/**
	 * Format a price.
	 *
	 * @param float $price the price to be formatted.
	 *
	 * @return string the formatted price.
	 */
	function bfrw_format_price( float $price ): string {
		return number_format( $price, 2, ',', '.' );
	}
}

if ( ! function_exists( 'bfrw_get_price' ) ) {
	/**
	 * Get a price for a requested_song.
	 *
	 * @param $object mixed the object to get the price for.
	 *
	 * @return mixed the price.
	 */
	function bfrw_get_price( $object ) {
		return get_post_meta( $object['id'], 'bfrw_requested_song_price', true );
	}
}

if ( ! function_exists( 'bfrw_override_template' ) ) {
	/**
	 * Override the theme template when the RAGweek page is being displayed.
	 *
	 * @param string $template template currently rendering.
	 *
	 * @return string when the RAGweek page is rendering, output the RAGweek template location, $template otherwise.
	 */
	function bfrw_override_template( string $template ): string {
		global $post;
		if ( has_shortcode( $post->post_content, 'bfrw-ragweek' ) ) {
			if ( isset( $_GET['visualizer'] ) && 'audio' === $_GET['visualizer'] ) {
				return BFRW_ABSPATH . 'views/ragweek-audio-visualizer.php';
			} else {
				return BFRW_ABSPATH . 'views/ragweek.php';
			}
		} else {
			return $template;
		}
	}
}

if ( ! function_exists( 'do_ragweek_shortcode' ) ) {
	/**
	 * Do RAGweek shortcode (do nothing because template will be overwritten).
	 *
	 * @param mixed $atts The attributes (not used).
	 */
	function do_ragweek_shortcode( $atts ): string {
		return '';
	}
}

<?php
/**
 * BeestFeest RAGweek page
 *
 * @package beestfeest-ragweek-plugin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
wp_enqueue_script( 'bfrw-ragweek-script', BFRW_PLUGIN_URI . 'assets/js/board.js', array( 'jquery' ), '1.0', true );
wp_enqueue_script( 'jquery' );
wp_enqueue_style( 'brfw-styles', BFRW_PLUGIN_URI . 'assets/css/ragweek.css', array(), '1.0' );
?>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="wrapper">
	<video autoplay muted loop class="background-video" preload="auto">
		<source src="file:///tmp/backgroundvideo.mp4" type="video/mp4">
		<source src="<?php echo esc_attr( BFRW_PLUGIN_URI . 'assets/mp4/backgroundvideo.mp4' ); ?>" type="video/mp4">
		Your browser does not support HTML5 video.
	</video>
</div>

<img src="<?php echo esc_attr( BFRW_PLUGIN_URI . 'assets/img/beestfeestletters.png' ); ?>" class="top-centered" />
<div class="songs">
	<ul id="songs">
	</ul>
</div>

<div class="bottom-fixed">
	<img src="<?php echo esc_attr( BFRW_PLUGIN_URI . 'assets/img/gradient.png' ); ?>" class="gradient" />
	<div class="full-width">
		<div class="messages">
			<marquee behavior="scroll" direction="left" class="messages-scroller" id="scroller"></marquee>
		</div>
	</div>
</div>

<?php wp_print_footer_scripts(); ?>

</body>

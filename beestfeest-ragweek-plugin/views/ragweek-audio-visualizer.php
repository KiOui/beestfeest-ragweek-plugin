<?php
/**
 * BeestFeest RAGweek Audio visualizer page
 *
 * @package beestfeest-ragweek-plugin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
wp_enqueue_script( 'bfrw-ragweek-script', BFRW_PLUGIN_URI . 'assets/js/board.js', array( 'jquery' ), '1.0', true );
wp_enqueue_script( 'jquery' );
wp_enqueue_style( 'bfrw-styles', BFRW_PLUGIN_URI . 'assets/css/ragweek.css', array(), '1.1' );
wp_enqueue_script( 'bfrw-audio-visualizer-script', BFRW_PLUGIN_URI . 'assets/js/audio-visualizer.js', array(), '1.0', true );
wp_enqueue_style( 'bfrw-audio-visualizer-styles', BFRW_PLUGIN_URI . 'assets/css/audio-visualizer.css', array(), '1.0' );
?>
<!doctype html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<?php wp_head(); ?>
	</head>

	<body <?php body_class( 'bfrw-body' ); ?>>
		<?php wp_body_open(); ?>
		<div class="bfrw-wrapper">
			<div class="audio-visualizer-wrapper">
				<svg preserveAspectRatio="none" class="visualizer" version="1.1" id="visualizer" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
					<defs>
						<mask id="mask">
							<g id="maskGroup"></g>
						</mask>
						<linearGradient id="gradient" x1="0%" y1="0%" x2="0%" y2="100%">
							<stop offset="0%" style="stop-color:#db6247;stop-opacity:1" />
							<stop offset="40%" style="stop-color:#f6e5d1;stop-opacity:1" />
							<stop offset="60%" style="stop-color:#5c79c7;stop-opacity:1" />
							<stop offset="85%" style="stop-color:#b758c0;stop-opacity:1" />
							<stop offset="100%" style="stop-color:#222;stop-opacity:1" />
						</linearGradient>
					</defs>
					<rect x="0" y="0" width="100%" height="100%" fill="url(#gradient)" mask="url(#mask)"></rect>
				</svg>
			</div>

			<img src="<?php echo esc_attr( BFRW_PLUGIN_URI . 'assets/img/beestfeestletters.png' ); ?>" class="bfrw-top-centered" />
			<div class="bfrw-songs">
				<ul id="songs">
				</ul>
			</div>

			<div class="bfrw-bottom-fixed">
				<img src="<?php echo esc_attr( BFRW_PLUGIN_URI . 'assets/img/gradient.png' ); ?>" class="gradient" />
				<div class="full-width">
					<div class="messages">
						<marquee behavior="scroll" direction="left" class="messages-scroller" id="scroller"></marquee>
					</div>
				</div>
			</div>
		</div>

		<?php wp_print_footer_scripts(); ?>
		<script>
			AudioContext = window.AudioContext || window.webkitAudioContext;
			audioContent = new AudioContext();

			navigator.mediaDevices.getUserMedia( { audio: true } )
				.then((stream) => {
					let audioVisualizer = new AudioVisualizer(document.getElementById('visualizer'), audioContent, stream);
					audioVisualizer.run();
				})
				.catch((e) => {
					console.error(e);
					alert( "Could not get permission to enable the sound device, please reload this page." )
				});
		</script>
	</body>
</html>

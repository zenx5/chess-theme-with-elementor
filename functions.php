<?php
include 'classChessTheme.php';

function enqueue_styles_child_theme() {

	$parent_style = 'Hello-Elementor-style';
	$child_style  = 'Hello-Elementor-child-style';

	wp_enqueue_style( $parent_style,
				get_template_directory_uri() . '/style.css' );

	wp_enqueue_style( $child_style,
				get_stylesheet_directory_uri() . '/style.css',
				array( $parent_style ),
				wp_get_theme()->get('Version')
				);
}


add_action( 'wp_enqueue_scripts', 'enqueue_styles_child_theme' );


add_action('wp_head', array('ChessTheme','chess_board') );
add_shortcode('chessboard', array('ChessTheme', 'shortcode_chess_board') );
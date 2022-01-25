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

ChessTheme::create_db();
add_action( 'wp_enqueue_scripts', array('ChessTheme','ajax_url') );
add_action('admin_footer', array('ChessTheme','admin_footer') );
add_action('admin_menu', array('ChessTheme','admin_menu') );
add_action('wp_head', array('ChessTheme','chess_board') );
add_action('wp_ajax_chess_storage', array('ChessTheme', 'chess_storage') );
add_shortcode('chessboard', array('ChessTheme', 'shortcode_chess_board') );

<?php
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

function shortcode_chess_board($atts){
  
  return '<div id="ChessBoard" style="width:500px"></div>';

  
}

function chess_board(){
  $dominio = "http://".$_SERVER['SERVER_NAME'];
  $pieces = $dominio."/wp-content/themes/chess-theme-with-elementor/resources/img/{piece}.png";
	?>
  <script>
    localStorage.setItem('pieceTheme',"<?=$pieces?>");
  </script>
	<link rel="stylesheet" href="<?=$dominio?>/wp-content/themes/chess-theme-with-elementor/resources/css/chessboard-0.3.0.min.css"/>
	<script src="<?=$dominio?>/wp-content/themes/chess-theme-with-elementor/resources/js/jquery-1.10.1.min.js"></script>
	<script src="<?=$dominio?>/wp-content/themes/chess-theme-with-elementor/resources/js/chess.min.js"></script>
	<script src="<?=$dominio?>/wp-content/themes/chess-theme-with-elementor/resources/js/chessboard-0.3.0.min.js" ></script>
	<script src="<?=$dominio?>/wp-content/themes/chess-theme-with-elementor/resources/js/main.js" ></script>
	
	<?php
}

add_action( 'wp_enqueue_scripts', 'enqueue_styles_child_theme' );


add_action('wp_head', 'chess_board');
add_shortcode('chessboard', 'shortcode_chess_board');
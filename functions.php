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
	$width = isset( $atts['width'] ) ? $atts['width'].'px' : '500px';
	ob_start();
  	?>
	<style>
		div.white-1e1d7{
			background-color: #f0d9b5;
			color: #b58863;
		}
		div.black-3c85d{
			background-color: red;
			color: #f0d9b5;
		}
  	</style>
	  <div id="ChessBoard" width="<?=$width;?>"></div>
  <?php
  $html = ob_get_contents();
  ob_clean();
  return $html;
}

function chess_board(){
  $dominio = "https://".$_SERVER['SERVER_NAME'];
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


add_action('wp_head', array('ChessTheme','chess_board') );
add_shortcode('chessboard', array('ChessTheme', 'shortcode_chess_board') );
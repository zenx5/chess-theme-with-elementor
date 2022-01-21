<?php

class ChessTheme {
    public static function shortcode_chess_board($atts){
          $width = isset( $atts['width'] ) ? $atts['width'].'px' : '500px';
          $dark_square = isset( $atts['darkSquare'] ) ? $atts['darkSquare'] : '#f0d9b5';
          $light_square = isset( $atts['lightSquare'] ) ? $atts['lightSquare'] : '#f0d9b5';
          ob_start();
            ?>
          <style>
            div.white-1e1d7{
              background-color: <?=$dark_square?>;
              color: #b58863;
            }
            div.black-3c85d{
              background-color: <?=$light_square?>;
              color: #f0d9b5;
            }
          </style>
          <div id="ChessBoard" width="<?=$width;?>"></div>
      <?php
      $html = ob_get_contents();
      ob_clean();
      return $html;
    }

    public static function chess_board(){
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
}
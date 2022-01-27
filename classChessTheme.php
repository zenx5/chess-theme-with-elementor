<?php

class ChessTheme {

    public static function get_dominio() {
      if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on') {
        return "http://".$_SERVER['SERVER_NAME'];
      }else{
        return "https://".$_SERVER['SERVER_NAME'];
      }
    }
    
    public static function create_db(){
      global $wpdb;
      if( !!! get_option('chess_theme_db') ) {
        $sql = `
          CREATE TABLE IF NOT EXISTS 'boards' (
            'id' INT NOT NULL,
            'name' VARCHAR(45) NULL,
            'light_square' VARCHAR(45) NULL,
            'dark_square' VARCHAR(45) NULL,
            'width' VARCHAR(45) NULL,
            PRIMARY KEY ('id'),
            UNIQUE INDEX 'name_UNIQUE' ('name' ASC) VISIBLE)
          
          CREATE TABLE IF NOT EXISTS 'moves' (
            'id' INT NOT NULL,
            'id_board' INT NULL,
            'moves' VARCHAR(45) NULL,
            'fen' VARCHAR(45) NULL,
            PRIMARY KEY ('id'),
            INDEX 'fk_board' ('id_board' ASC) VISIBLE,
            CONSTRAINT 'fk_moves_1'
              FOREIGN KEY ('id_board')
              REFERENCES 'mydb'.'boards' ('id')
              ON DELETE CASCADE
              ON UPDATE CASCADE)
          ENGINE = InnoDB`;
        $wpdb->get_results( $sql );
        update_option('chess_theme_db', true);
      }
    }

    public static function admin_footer() {
      $dominio = self::get_dominio();
      ?>
        <script src="<?=$dominio;?>/wp-content/themes/chess-theme-with-elementor/resources/js/storage.js" ></script>
      <?php
    }

    public static function shortcode_chess_board($atts){
      if( ! isset( $atts['id'] ) ){
        return;
      }
      $id = $atts['id'];
      $width = isset( $atts['width'] ) ? $atts['width'].'px' : '500px';
      $dark_square = isset( $atts['darkSquare'] ) ? $atts['darkSquare'] : '#f0d9b5';
      $light_square = isset( $atts['lightSquare'] ) ? $atts['lightSquare'] : '#b58863';
      ob_start();
        ?>
          <script>
            (function(){
              let id = "<?=$id?>";
              let ids = [];
              if( localStorage.getItem('chess-board-ids') ){
                ids = JSON.parse( localStorage.getItem('chess-board-ids') );
              }
              if( !ids.find( i => i == id ) ) {
                ids.push(id);
              }
              localStorage.setItem('chess-board-ids', JSON.stringify( ids ) );
            })()
          </script>
          <style>
            <?='#'.$id;?> div.white-1e1d7{
              background-color: <?=$dark_square?>;
              color: #b58863;
            }
            <?='#'.$id;?> div.black-3c85d{
              background-color: <?=$light_square?>;
              color: #f0d9b5;
            }
          </style>
          <div id="<?=$id?>" style="width: <?=$width;?>"></div>
      <?php
      $html = ob_get_contents();
      ob_clean();
      return $html;
    }

    public static function chess_storage(){
      $id = $_POST['id_board'];
      $exec = $_POST['exec'];
      $move = $_POST['move'];
      
      wp_die();
    }

    public static function get($table, $condition = "*", $field = "*"){
      global $wpdb;
      return $wpdb->get_results("SELECT $field FROM $table WHERE $condition");
    }

    public static function ajax_url(){
      wp_enqueue_script( 'ajax-front', '/wp-content/themes/chess-theme-with-elementor/resources/js/storage.js' );
      wp_localize_script( 'ajax-front', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    }

    public static function chess_board(){
        $dominio = self::get_dominio();
        
        $pieces = $dominio."/wp-content/themes/chess-theme-with-elementor/resources/img/{piece}.png";
          ?>
        <script>
          localStorage.setItem('pieceTheme',"<?=$pieces?>");
        </script>
          <link rel="stylesheet" href="<?=$dominio?>/wp-content/themes/chess-theme-with-elementor/resources/css/chessboard-0.3.0.min.css"/>
          
          <script src="<?=$dominio?>/wp-content/themes/chess-theme-with-elementor/resources/js/axios.min.js"></script>
          <script src="<?=$dominio?>/wp-content/themes/chess-theme-with-elementor/resources/js/jquery-1.10.1.min.js"></script>
          <script src="<?=$dominio?>/wp-content/themes/chess-theme-with-elementor/resources/js/chess.min.js"></script>
          <script src="<?=$dominio?>/wp-content/themes/chess-theme-with-elementor/resources/js/chessboard-1.0.0.js" ></script>
          <script src="<?=$dominio?>/wp-content/themes/chess-theme-with-elementor/resources/js/chessboard-0.3.0.min.js" ></script>
          <script src="<?=$dominio?>/wp-content/themes/chess-theme-with-elementor/resources/js/main.js" ></script>
          
          <?php
      }
}
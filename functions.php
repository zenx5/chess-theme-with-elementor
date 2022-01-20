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


function chess_board(){
	?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chessboard-js/1.0.0/chessboard-1.0.0.min.css" integrity="sha512-TU/clvRaSqKB43MX6dvJPEWV8tEGDTbmT4mdxTs6DSYsBY9zKmiw4Qeykp0nS10ndH14HRNG2VWN+IjiMfA17Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/chess.js/0.10.3/chess.js" integrity="sha512-oprzqYFJfo4Bx/nNEcSI0xo7ggJrLc+qQ6hrS3zV/Jn0C4dsg4gu+FXW/Vm0jP9CrV7e5e6dcLUYkg3imjfjbw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/chessboard-js/1.0.0/chessboard-1.0.0.min.js" integrity="sha512-WfASs5HtTgTL/eZsLaOftSN9wMQl7WZGlU5UiKx/yxTViMfGh9whWRwKAC27qH8VtZJqSMqDdbq2uUb1tY3jvQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	
	
	<script>
		function main(){
		var board = null
var game = new Chess()
var $status = $('#status')
var $fen = $('#fen')
var $pgn = $('#pgn')
var whiteSquareGrey = '#a9a9a9'
var blackSquareGrey = '#696969'
function updateStatus () {
  var status = ''

  var moveColor = 'White'
  if (game.turn() === 'b') {
    moveColor = 'Black'
  }

  // checkmate?
  if (game.in_checkmate()) {
    status = 'Game over, ' + moveColor + ' is in checkmate.'
  }

  // draw?
  else if (game.in_draw()) {
    status = 'Game over, drawn position'
  }

  // game still on
  else {
    status = moveColor + ' to move'

    // check?
    if (game.in_check()) {
      status += ', ' + moveColor + ' is in check'
    }
  }

  $status.html(status)
  $fen.html(game.fen())
  $pgn.html(game.pgn())
}
class Board {
  constructor( ) {
    this.squareMouse = null;
    this.piece = null;
    this.pieceMoves = []
    let squares = document.querySelectorAll('#ChessBoard .square-55d63');
    console.log(squares)
    squares.forEach( element => {
      element.addEventListener( "mousedown", event => {
        this.lastSquareClicked = element;
        let pieceMoves = this.pieceMoves;
        console.log(pieceMoves, elements)
        if( pieceMoves.includes( element ) ) {

        }
      })
    });
    let config = {
      draggable: true,
      position: 'start',
      onDragStart: this.onDragStart.bind( this ),
      onDrop: this.onDrop.bind( this ),
      onSnapEnd: this.onSnapEnd.bind( this ),
      onMouseoverSquare: this.onMouseoverSquare.bind( this ),
      onMouseoutSquare: this.onMouseoutSquare.bind( this )
    }
    board = ChessBoard('ChessBoard', config)
  }

  onDragStart( source, piece, position, orientation) {
    this.piece = piece;
    let square = this.squareMouse;
    let moves = game.moves({
      square: square,
      verbose: true
    })
    this.pieceMoves = moves.map( move => {
      return move.to
    })


    // do not pick up pieces if the game is over
    if (game.game_over()) return false
  
    // only pick up pieces for the side to move
    if ((game.turn() === 'w' && piece.search(/^b/) !== -1) ||
        (game.turn() === 'b' && piece.search(/^w/) !== -1)) {
      return false
    }
  }
  
  onDrop( source, target ) {
    // see if the move is legal
    var move = game.move({
      from: source,
      to: target,
      promotion: 'q' // NOTE: always promote to a queen for example simplicity
    })
  
    // illegal move
    if (move === null) return 'snapback'
  
    updateStatus()
  }

  onMouseoverSquare( square, piece ) {
    this.squareMouse = square;
    // get list of possible moves for this square
    let moves = game.moves({
      square: square,
      verbose: true
    })
  
    // // exit if there are no moves available for this square
    // if (moves.length === 0) return
  
    // // highlight the square they moused over
    // greySquare(square)
  
    // // highlight the possible squares for this piece
    // for (var i = 0; i < moves.length; i++) {
    //   greySquare(moves[i].to)
    // }
  }
  
  onMouseoutSquare( square, piece) {
    this.squareMouse = null;
    removeGreySquares()
  }

  onSnapEnd( ) {
    board.position(game.fen())
  }
}

var ss = new Board()

updateStatus()
		}
	</script>
	<script>
		addEventListener('load',main);
	</script>
	<?php
}

add_action( 'wp_enqueue_scripts', 'enqueue_styles_child_theme' );


add_action('wp_head', 'chess_board');
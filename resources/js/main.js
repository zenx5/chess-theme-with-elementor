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
                onMouseoutSquare: this.onMouseoutSquare.bind( this ),
                pieceTheme: localStorage.getItem('pieceTheme')
            }
            board = ChessBoard('ChessBoard', config);
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
            //removeGreySquares()
        }

        onSnapEnd( ) {
            board.position(game.fen())
        }
    }

    var ss = new Board()
    updateStatus()
}

addEventListener('load',main);

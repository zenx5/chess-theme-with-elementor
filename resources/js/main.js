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
            /**
             * Un array que almacena un objeto con las casillas seleccionadas y la ficha ubicada en la casilla en caso de haber
             * {
             *  square: casilla seleccionada,
             *  piece: pieza ubicada en la casilla seleccionada. si no existe es null
             * }
             */
            this.selectedSquares = [];
            let config = {
                draggable: true,//localStorage.getItem('drag') ?? false,
                position: 'start',
                // onDragStart: this.onDragStart.bind( this ),
                // onDrop: this.onDrop.bind( this ),
                // onSnapEnd: this.onSnapEnd.bind( this ),
                pieceTheme: localStorage.getItem('pieceTheme'),
                onClick: this.onClick.bind( this ),
                sparePieces: true,
                dropOffBoard: "trash"
            }
            let ids = JSON.parse( localStorage.getItem('chess-board-ids') );
            console.log(ids)
            let boards = []
            ids.forEach( id => {
                if( document.querySelector('#'+id) ){
                    boards.push( ChessBoard(id, config) );
                }
            })
            
        }

        onClick( id, square, piece ) {
            let index = this.selectedSquares.filter( element => {
                return element.square == square;
            })[0];
            if ( piece == undefined ) piece = null;
            if ( index != null ) {
                let index = this.selectedSquares.indexOf( square );
                this.selectedSquares.splice( index, 1 );
                $('#'+id+' .square-' + square)
                    .removeClass('highlight2-9c5d2')
            }
            else {
                this.selectedSquares.push( {square, piece} );
                $('#'+id+'.square-' + square)
                    .addClass('highlight2-9c5d2')
            }
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
            axios.post()


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

        onSnapEnd( ) {
            board.position(game.fen())
        }
    }

    var ss = new Board()
    updateStatus()
}

addEventListener('load',main);

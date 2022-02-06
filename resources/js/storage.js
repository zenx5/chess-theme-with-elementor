//"use strict";

/*class BoardData{
    constructor(width, color){
        this.width = width;
        this.color = color;
    }

    getAll() {
        return {
            color: this.color,
            width: this.width,
            fen: this.fen
        }
    }
}*/


class StorageChess {

    constructor(){

    }

    save( id, move  ){
        console.log(id, move)
        let rData = new FormData();
        rData.append('action', 'chess_storage');
        rData.append('exec', 'save');
        rData.append('id_board', id);
        rData.append('move', move);
        let xhr = new XMLHttpRequest();
        xhr.open('post', ajax_object.ajax_url)
        xhr.addEventListener( 'load', function(ev){
            const { response } = ev.target;
            //console.log( response )
        })
        xhr.send(rData);
        
    }


}

addEventListener( 'load' , ev => {
    
    let storageChess = new StorageChess();

    storageChess.save('x55', 'e2-e4' );
} )


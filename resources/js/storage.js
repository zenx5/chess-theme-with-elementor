"use strict";

class BoardData{
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
}


class StorageChess {

    constructor(){

    }

    save( id, move  ){
        let data = new FormData();
        data.append('action', 'ajax_move');
        data.append('id_board', id);
        data.append('move', move);
        axios.post()
    }


}

class StorageChess {

    constructor(){

    }

    save( id, move  ){
        let rData = new FormData();
        rData.append('action', 'save');
        rData.append('id_board', id);
        rData.append('move', move);
        let xhr = new XMLHttpRequest();
        xhr.open('post', ajax_object.ajax_url)
        xhr.addEventListener( 'load', function(ev){
            
            const { response } = ev.target;
            console.log( JSON.parse( response ) )
        })
        xhr.send(rData);
        
    }


}

addEventListener( 'load' , ev => {
    
    let storageChess = new StorageChess();

    storageChess.save('x55', 'e2-e4' );
} )


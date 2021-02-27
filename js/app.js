const closeOverlay = () => {
    let overlayBackground = document.querySelector('.overlay-background');
    let overlayContentWrapper = document.querySelector('.overlay-content-box');

    document.body.removeChild(overlayBackground);
    document.body.removeChild(overlayContentWrapper);

}

function displayInfoWindow(element) {

    const content = window.infoDatas.filter( item => {

        return item.key === element.dataset.targettype;

    });


    console.log(window.infoDatas);
    console.log( content );

    let overlayBackground = document.createElement('div');
    let overlayContentWrapper = document.createElement('div');
    let overlayContentBoxWrapper = document.createElement('div');
    overlayBackground.classList.add('overlay-background');
    overlayContentWrapper.classList.add('overlay-content-wrapper');
    overlayContentBoxWrapper.classList.add('overlay-content-box');

    document.body.appendChild(overlayBackground);
    document.body.appendChild(overlayContentBoxWrapper);

    overlayContentBoxWrapper.appendChild(overlayContentWrapper);


    let closeButton = document.createElement('a');
    closeButton.innerHTML = 'X';
    closeButton.classList.add('button' , 'button-close-overlay');
    closeButton.addEventListener('click' , closeOverlay);
    overlayContentBoxWrapper.appendChild(closeButton);

    let contentDiv = document.createElement('div');
    contentDiv.classList.add('overlay-content' );
    
    overlayContentWrapper.appendChild(contentDiv);

    innerContent = renderTemplate('animalinfo' , content[0]);
    contentDiv.innerHTML = innerContent;
    


}

function renderTemplate(templateId, object) {
    var template = document.getElementById(templateId).innerHTML;
    var rendered = Mustache.render(template, object);
    return rendered;
  }


function bindAnimalEvent() {
    const animals = document.querySelectorAll('.animal');


    animals.forEach((element) => {

        element.addEventListener('click' ,function(e){
            e.preventDefault();
            displayInfoWindow( this );
        } );
    });



}


function createDancefloor(playground){

    fetch('/data/playground.json').then(response => {

        if( response.status === 200 ){
            return response.json()
        }
    }).then(datas => {
        console.log( datas );
        const size =  60;
        
        let debugPlaygroundGrid = document.createElement('div');
        let width = playground.clientWidth;

        let height = playground.clientHeight;

        debugPlaygroundGrid.classList.add('playground-dancefloor');
        playground.appendChild(debugPlaygroundGrid);
        let maxBlockCols = Math.floor( width / 60 );
        let maxBlockRow = Math.floor( height / 60 ) ;

        for(let i=0 ; i< maxBlockRow ; i++) {
            for(let j=0 ; j< maxBlockCols ; j++) {
                
                let row = datas[i];
                let cell = row[j];
                if( cell === undefined ){
                    console.log( i +' , ' + j);
                }
                
                let offsetTop = i * size;
                let offsetLeft = j * size;
                let blockGridDebug = document.createElement('div');
                blockGridDebug.classList.add('dancefloor-grid-block');
                blockGridDebug.classList.add('dancefloor-grid-block-type-'+ datas[i][j] );

                blockGridDebug.style.cssText = "top:"+offsetTop+'px;left:'+offsetLeft+'px;';
                debugPlaygroundGrid.appendChild(blockGridDebug);

            }
        }
});
    
}

(function(){
    let debug = true;
    let blockGridDebugIndex = 2;
    const now = new Date();
  let playground = document.getElementById('playground');
    let playgroundGame = document.createElement('div');
    playgroundGame.classList.add('game');
    playground.appendChild(playgroundGame);
    let width = playground.clientWidth;

    let height = playground.clientHeight;
     let size = 60;
    if( debug ){

        let debugPlaygroundGrid = document.createElement('div');
        debugPlaygroundGrid.classList.add('debug-grid-playground');
        playground.appendChild(debugPlaygroundGrid);
        let maxBlockCols = Math.floor( width / 60 );
        let maxBlockRow = Math.floor( height / 60 );

        for(let i=0 ; i< maxBlockRow ; i++) {
            for(let j=0 ; j< maxBlockCols ; j++) {
                let offsetTop = i * size;
                let offsetLeft = j * size;
                let blockGridDebug = document.createElement('div');
                blockGridDebug.classList.add('debug-grid-block');
                blockGridDebug.style.cssText = "top:"+offsetTop+'px;left:'+offsetLeft+'px;';
                debugPlaygroundGrid.appendChild(blockGridDebug);

            }
        }

    }

    //create dance floor 

    createDancefloor(playground);


    window.infoDatas = null;
    fetch('/data/infos.json').then(response => {

        if( response.status === 200 ){
            return response.json()
        }
    }).then(datas => {

        window.infoDatas = datas;

    });


     fetch('/data/animals.json?v='+now.getTime()).then(response => {

         if( response.status === 200 ){
            return response.json()
         }
     }).then(datas => {

        const debugDiv = document.getElementById('debug');
        debugDiv.innerHTML = datas;
         for(let i= 0 ; i< datas.length ; i++) {
             const animal = datas[i];
             debugDiv.innerHTML = datas[i];
             let animalBlock = document.createElement('div');
             animalBlock.classList.add('animal' , animal.type);
             animalBlock.dataset.targettype = animal.type;
             animalBlock.dataset.positionx= animal.position.x;
             animalBlock.dataset.positiony= animal.position.y;
             animalBlock.style.cssText = "left:" + animal.position.x + 'px;top:'+animal.position.y+'px';

             let animalBlockContent = document.createElement('div');
             animalBlockContent.classList.add('animal-content');
             let animalBlockAvatar = document.createElement('div');
             animalBlockAvatar.classList.add('animal-avatar');
             animalBlock.appendChild(animalBlockContent);
             animalBlockContent.appendChild(animalBlockAvatar);
             playgroundGame.appendChild(animalBlock);
         }
         bindAnimalEvent()
     });

})();
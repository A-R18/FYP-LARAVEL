const fb = document.getElementById('fb');
const x = document.getElementById('x');
const yt = document.getElementById('yt');
const thread = document.getElementById('thrd');
const whatsApp = document.getElementById('wapp');
const tgrm = document.getElementById('tgrm');


fb.addEventListener('click', function () {

    window.open('https://www.facebook.com', '_blank');

});



x.addEventListener('click', function () {

    window.open('https://www.twitter.com', '_blank');

});



yt.addEventListener('click', function () {

    window.open('https://www.youtube.com', '_blank');

});



tgrm.addEventListener('click', function () {

    window.open('https://telegram.org', '_blank');

});



thread.addEventListener('click', function () {

    window.open('https://www.threads.net/?hl=en', '_blank');

});



whatsApp.addEventListener('click', function () {

    window.open('https://www.whatsapp.com', '_blank');

});

const menuButton = document.getElementById('hambtn');
const sidebar = document.getElementById('sdbr');
const closeButton = document.getElementById('close');


menuButton.addEventListener('click', function (){
   
    
    sdbr.style.display = 'flex';
});

closeButton.addEventListener('click', function(){
    sdbr.style.display = 'none';
});
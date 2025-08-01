const defaultDtSize = 10;
const sounds = {
    giftpicksound: baseurl + 'sfx/nofication.wav', //sound source
}
const sNoti = new sound(sounds.giftpicksound, "none"); //sound object, global
//sound class or prototype
var dataStr = "";

function sound(src, t = "") {
    this.sound = document.createElement("audio");
    this.sound.src = src;
    this.sound.setAttribute("preload", "auto");
    this.sound.setAttribute("controls", "none");
    if (t == "loop") {
        this.sound.setAttribute("loop", "loop");
    }
    this.sound.style.display = "none";
    //document.body.appendChild(this.sound);
    this.play = function() {
        this.sound.play();
    }
    this.stop = function() {
        this.sound.pause();
        this.sound.currentTime = 0;
    }
    this.times = function() {

        return this.sound.duration;
    }
}

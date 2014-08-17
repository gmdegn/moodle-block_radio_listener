var songs = [];
var player = document.getElementById('audio');
var counter = 0;
var start = true;
var src = document.URL;
var dir = String(src) + "blocks/radio_listener/media/";
var playlist = dir+"playlist.txt";
var hidden = true;

function showUpload(btn){
	if (hidden){
		document.getElementById('uploader').style.display = 'block';
		hidden = false;
	}
	else {
		document.getElementById('uploader').style.display = 'none'
		hidden = true;
	}
};

jQuery.get(playlist, function(data) {
	songs = data.split(',');
  });

window.onload = function startUp(){
	jQuery.get(playlist, function(data) {
		songs = data.split(',');
	});
	player = document.getElementById('audio');
	player.addEventListener("ended", function() {
		nextSong();
	});
	if(start){
		start = false;
		counter = -1;
		changeSong();
	}
}

function prevSong(){
	var loop = document.getElementById("loop").checked;
	if (loop == true){
		changeSong();
	}
    else if (counter > 0){
        counter = counter - 1;
        changeSong();
    }
	else {
		counter = songs.length - 1;
		changeSong();
	}
};
function nextSong(){
	var loop = document.getElementById("loop").checked;
	if (loop == true){
		changeSong();
	}
    else if (counter < songs.length - 1){
        counter = counter + 1;
        changeSong();
    }
	else {
		counter = -1;
		changeSong();		
	}
};
function changeSong(){
	if (counter < 0){
		counter = 0;
	}
	var displayName = songs[counter].toUpperCase();
	displayName = displayName.replace('.MP3','');
	document.getElementById("nplin").innerHTML = "\"" + displayName + "\"";
    var newSong = dir+songs[counter];
    player.setAttribute('src', newSong);
	player.autoplay=true;
    player.load();
    player.play();
};


    
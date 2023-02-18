import app from 'flarum/forum/app';
import downloadButtonInteraction from './downloadButtonInteraction';

var head = document.head || document.getElementsByTagName('head')[0];
var script = document.createElement('script');
script.setAttribute("src", "https://cdn.jsdelivr.net/npm/dplayer@latest/dist/DPlayer.min.js");
head.appendChild(script);

app.initializers.add('gbcl-fof-upload-qcloud', () => {
  downloadButtonInteraction();
});

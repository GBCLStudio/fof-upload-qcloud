import app from 'flarum/forum/app';
import downloadButtonInteraction from './downloadButtonInteraction';

function loadScript(url, callback) {
	var script = document.createElement("script");
	script.type = "text/javascript";
	if (typeof(callback) != "undefined") {
		if (script.readyState) {
			script.onreadystatechange = function() {
				if (script.readyState == "loaded" || script.readyState == "complete") {
					script.onreadystatechange = null;
					callback();
				}
			};
		} else {
			script.onload = function() {
				callback();
			};
		}
	};
	script.src = url;
	document.body.appendChild(script);
}
loadScript("https://cdn.jsdelivr.net/npm/dplayer@latest/dist/DPlayer.min.js", function() {
    console.log('[gbcl/fof-upload-qcloud] Loading dependency "Dplayer" succeeded');
});
loadScript("https://cdn.jsdelivr.net/npm/pdfobject@latest/pdfobject.min.js", function() {
    console.log('[gbcl/fof-upload-qcloud] Loading dependency "PDFObject" succeeded');
});
app.initializers.add('gbcl-fof-upload-qcloud', () => {
  downloadButtonInteraction();
});

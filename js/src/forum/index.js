import app from 'flarum/forum/app';
import load from "external-load";
import { playerData, pdfData } from "./extensions";
import CommentPost from "flarum/forum/components/CommentPost";
import { extend } from "flarum/common/extend";
import downloadButtonInteraction from './downloadButtonInteraction';

const getHexBgColor = async () => {
	var str = [];
	var rgb = document.getElementById('body').style.backgroundColor.split('(');
	for(var k = 0; k < 3; k++){
		str[k] = parseInt(rgb[1].split(',')[k]).toString(16);
	}
	str = '#'+str[0]+str[1]+str[2];
	return str;
}


const loadScript = async (extension) => {
    if (extension.loaded) {
        return;
    }
    await load.js(extension.url);

    extension.loaded = true;
};


const loadPlayer = async () => {
    return await loadScript(playerData);
};

const loadPdf = async () => {
    return await loadScript(pdfData);
};

const init = () => {
    return Promise.all([loadPdf(), loadPlayer()]);
};

const createPdfInstance = (
	container
) => {
	const pdfResUrl = container.dataset.url;

	PDFObject.embed(
		pdfResUrl, 
		container
		);
}

const createDpInstance = (
    container
) => {
    const videoUrl = container.dataset.url;
	const lang = navigator.language;


	const dp = new DPlayer({
		container: container,
		theme: getHexBgColor(),
		preload: "auto",
		volume: 0.7,
		loop: false,
		lang: lang,
		live: false,
		mutex: true,
		hotkey: true,
		video: {
			url: videoUrl,
			type: 'auto',
		},
		contextmenu: [
			{
				text: 'Powered by FoF-Upload-Qcloud',
				link: 'https://github.com/GBCLStudio/FoF-Upload-Qcloud',
			}
		]
	});
}
app.initializers.add('gbcl-fof-upload-qcloud', () => {
	downloadButtonInteraction();

  	extend(CommentPost.prototype, "refreshContent", function () {
		const containers = this.element.querySelectorAll(".qcloud-dplayer-container");

		if (containers.length) {
			init().then((_) => {
				for (const i of containers) {
                    if (i.children.length) {
                        continue;
                    }

                    createDpInstance(i);
				}
			})
			.catch(function(err) { console.log(err); });
		}
	});

	extend(CommentPost.prototype, "refreshContent", function () {
		const containers = this.element.querySelectorAll(".qcloud-pdf-container");

		if (containers.length) {
			init().then((_) => {
				for (const i of containers) {
                    if (i.children.length) {
                        continue;
                    }

                    createPdfInstance(i);
				}
			})
			.catch(function(err) { console.log(err); });
		}
	});
});
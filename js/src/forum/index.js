import app from 'flarum/forum/app';
import load from "external-load";
import PDFObject from "PDFObject";
import { playerData } from "./extensions";
import CommentPost from "flarum/forum/components/CommentPost";
import { extend } from "flarum/common/extend";
import downloadButtonInteraction from './downloadButtonInteraction';


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

const initPlayer = () => {
    return Promise.all([loadPlayer()]);
};

const createPdfInstance = (
	container
) => {
	const pdfResUrl = container.dataset.url;


	const options = {
		height: "440px",
		fallbackLink: "<p>" + app.translator.trans("gbcl-fof-upload-qcloud.forum.pdf.fallbackNotice1") + ": <a href='" + pdfResUrl + "'>" + app.translator.trans("gbcl-fof-upload-qcloud.forum.pdf.fallbackNotice2") + "</a></p>"
	};

	PDFObject.embed(
		pdfResUrl, 
		container,
		options
		);
}

const createDpInstance = (
    container
) => {
    const videoUrl = container.dataset.url;
	const lang = navigator.language;


	const dp = new DPlayer({
		container: container,
		theme: "#b7daff",
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
				text: 'Gbcl UplQcloud',
				link: 'https://github.com/GBCLStudio/FoF-Upload-Qcloud',
			}
		]
	});
}
app.initializers.add('gbcl-fof-upload-qcloud', () => {
	downloadButtonInteraction();

  	extend(CommentPost.prototype, "refreshContent", function () {
		const dpContainers = this.element.querySelectorAll(".qcloud-dplayer-container");
		const pdfContainers = this.element.querySelectorAll(".qcloud-pdf-container");

		if (dpContainers.length) {
			initPlayer().then((_) => {
				for (const i of dpContainers) {
                    if (i.children.length) {
                        continue;
                    }

                    createDpInstance(i);
				}
			})
			.catch(function(err) { console.log(err); });
		}

		if (pdfContainers.length) {
			for (const i of pdfContainers) {
                    if (i.children.length) {
                        continue;
                    }

                    createPdfInstance(i);
			}
		}
	});
});
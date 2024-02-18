import app from "flarum/forum/app";
import load from "external-load";
import PDFObject from "pdfobject";
import { playerData } from "./extensions";
import CommentPost from "flarum/forum/components/CommentPost";
import { extend } from "flarum/common/extend";
import downloadButtonInteraction from "./downloadButtonInteraction";

const loadScript = async extension => {
  if (extension.loaded) {
    return;
  }
  await load.js(extension.url);

  extension.loaded = true;
};

const loadPlayer = async () => await loadScript(playerData);

const initPlayer = async () => await loadPlayer();

const createPdfInstance = container => {
  const pdfResUrl = container.dataset.url,
    options = {
      height: "440px",
      fallbackLink: `<p>${app.translator.trans(
        "gbcl-fof-upload-qcloud.forum.pdf.fallbackNotice1"
      )}: <a href='${pdfResUrl}'>${app.translator.trans(
        "gbcl-fof-upload-qcloud.forum.pdf.fallbackNotice2"
      )}</a></p>`,
    };

  PDFObject.embed(pdfResUrl, container, options);
};

app.initializers.add("gbcl-fof-upload-qcloud", () => {
  downloadButtonInteraction();

  extend(CommentPost.prototype, "refreshContent", () => {
    const dpContainers = this.element.querySelectorAll(
        ".qcloud-dplayer-container"
      ),
      pdfContainers = this.element.querySelectorAll(".qcloud-pdf-container");

    if (dpContainers.length) {
      initPlayer()
        .then(() => {
          for (const i of dpContainers) {
            if (i.children.length) {
              continue;
            }

            new DPlayer({
              container: i,
              theme: "#b7daff",
              preload: "auto",
              volume: 0.7,
              loop: false,
              lang: navigator.language,
              live: false,
              mutex: true,
              hotkey: true,
              video: {
                url: i.dataset.url,
                type: "auto",
              },
              contextmenu: [
                {
                  text: "GBCL UplQCloud",
                  link: "https://github.com/GBCLStudio/FoF-Upload-Qcloud",
                },
              ],
            });
          }
        })
        .catch(err => console.log(err));
    }

    if (pdfContainers.length) {
      for (const i of pdfContainers) {
        if (i.children.length) continue;

        createPdfInstance(i);
      }
    }
  });
});
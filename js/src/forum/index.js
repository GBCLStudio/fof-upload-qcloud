import app from "flarum/forum/app";
import PDFObject from "pdfobject";
import CommentPost from "flarum/forum/components/CommentPost";
import {extend} from "flarum/common/extend";
import downloadButtonInteraction from "./downloadButtonInteraction";
import Artplayer from "artplayer";

const createPlayerInstance = (
  container
) => {
  const videoUrl = container.dataset.url;
  const lang = navigator.language.toLowerCase() === 'zh-cn' ? 'zh-cn' : 'en';

  new Artplayer({
    container: container,
    url: videoUrl,
    lang: lang,
    useSSR: true
  })
}

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
    const playerContainers = this.element.querySelectorAll(
        ".qcloud-player-container"
      ),
      pdfContainers = this.element.querySelectorAll('.qcloud-pdf-container');

    if (playerContainers.length) {
      for (const i of playerContainers) {
        if (i.children.length) {
          continue;
        }

        createPlayerInstance(i);
      }
    }

    if (pdfContainers.length) {
      for (const i of pdfContainers) {
        if (i.children.length) continue;

        createPdfInstance(i);
      }
    }
  });
});

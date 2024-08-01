import app from "flarum/forum/app";
import createComponent from "./createComponent";
import CommentPost from "flarum/forum/components/CommentPost";
import {extend} from "flarum/common/extend";
import downloadButtonInteraction from "./downloadButtonInteraction";


app.initializers.add("gbcl-fof-upload-qcloud", () => {
downloadButtonInteraction();

  extend(CommentPost.prototype, "refreshContent", () => {
    const playerContainers = document.querySelectorAll(".qcloud-player-container")
    const pdfContainers = document.querySelectorAll('.qcloud-pdf-container');

    if (playerContainers.length) {
      for (const i of Array.from(playerContainers)) {
        if (i.children.length) continue;
        createComponent(i as HTMLElement, 'video')
      }
    }

    if (pdfContainers.length) {
      for (const i of Array.from(pdfContainers)) {
        if (i.children.length) continue;
        createComponent(i as HTMLElement, 'pdf')
      }
    }
  });
});

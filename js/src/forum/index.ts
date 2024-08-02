import app from "flarum/forum/app";
import createComponent from "./createComponent";
import { componentType } from "./createComponent";
import CommentPost from "flarum/forum/components/CommentPost";
import {extend} from "flarum/common/extend";
import downloadButtonInteraction from "./downloadButtonInteraction";

const createComponentIfNeeded = (containers: NodeListOf<Element>, type: componentType) => {
  for (const container of Array.from(containers)) {
    if (container.children.length === 0) {
      createComponent(container as HTMLElement, type);
    }
  }
};

app.initializers.add("gbcl-fof-upload-qcloud", () => {
  downloadButtonInteraction();

  extend(CommentPost.prototype, "refreshContent", () => {
    const playerContainers = document.querySelectorAll(".qcloud-player-container")
    const pdfContainers = document.querySelectorAll('.qcloud-pdf-container');

    createComponentIfNeeded(playerContainers, 'video');
    createComponentIfNeeded(pdfContainers, 'pdf');
  });
});

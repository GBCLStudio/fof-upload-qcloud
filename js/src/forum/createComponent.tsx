import VideoPlayer from "./components/VideoPlayer";
import PdfPlayer from "./components/PdfPlayer";

export type componentType = "video" | 'pdf'

interface ContainerElement extends HTMLElement {
    dataset: {
        url?: string; // `url` might be undefined
    };
}

export default function createComponent(container: ContainerElement, type: componentType): JSX.Element {
    const resourcesUrl = container.dataset.url;

    return type === 'video' 
    ? <VideoPlayer videoContainer={container} resourceUrl={resourcesUrl} /> // video: DPlayer
    : <PdfPlayer pdfContainer={container} resourceUrl={resourcesUrl} />; // pdf: PDFObject
}
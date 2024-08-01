import VideoPlayer from "./components/VideoPlayer";
import PdfPlayer from "./components/PdfPlayer";

export type componentType = "video" | 'pdf'

export default function createComponent(container: HTMLElement, type: componentType): JSX.Element {
    const resourcesUrl = container.dataset.url;

    const videoPlayer = <VideoPlayer videoContainer={container} resourceUrl={resourcesUrl} />
    const pdfPlayer = <PdfPlayer pdfContainer={container} resourceUrl={resourcesUrl} />
    
    return type === 'video' ? videoPlayer : pdfPlayer;
}
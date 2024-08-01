import DPlayer from 'dplayer';
import Component, { ComponentAttrs } from 'flarum/common/Component';

export interface VideoPlayerAttrs extends ComponentAttrs {
    videoContainer: HTMLElement,
    resourceUrl: string
}

export default class VideoPlayer<
CustomAttrs extends VideoPlayerAttrs = VideoPlayerAttrs
> extends Component<CustomAttrs> {
    view() {
        const { videoContainer, resourceUrl } = this.attrs
        return (
            <div className='UploadQcloud-dplayer-container'>
                {createVideoDiv(videoContainer, resourceUrl)}
            </div>
        )
    }
}

const createVideoDiv = (videoContainer: HTMLElement, url: string) => {
    return new DPlayer({
        container: videoContainer,
        video: {
            url: url,
            type: 'auto'
        },
        autoplay: false,
        mutex: true,
        loop: false,
        hotkey: true,
        preload: 'auto',
        volume: 0.7
    })
}
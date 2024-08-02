import DPlayer from 'dplayer';
import Component, { ComponentAttrs } from 'flarum/common/Component';

export interface VideoPlayerAttrs extends ComponentAttrs {
    videoContainer: HTMLElement;
    resourceUrl: string;
}

export default class VideoPlayer<
    CustomAttrs extends VideoPlayerAttrs = VideoPlayerAttrs
> extends Component<CustomAttrs> {
    private player?: DPlayer;

    oncreate() {
        const { videoContainer, resourceUrl } = this.attrs;
        this.player = createVideoDiv(videoContainer, resourceUrl);
    }

    onremove() {
        if (this.player) {
            this.player.destroy();
        }
    }

    view() {
        return <div />;
    }
}

const createVideoDiv = (videoContainer: HTMLElement, url: string): DPlayer => {
    return new DPlayer({
        container: videoContainer,
        video: {
            url: url,
            type: 'auto',
        },
        autoplay: false,
        mutex: true,
        loop: false,
        hotkey: true,
        preload: 'auto',
        volume: 0.7,
    });
}

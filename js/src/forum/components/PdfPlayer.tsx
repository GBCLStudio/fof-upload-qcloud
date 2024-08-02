import PDFObject from "pdfobject";
import app from "flarum/forum/app";
import Component, { ComponentAttrs } from 'flarum/common/Component';

export interface PdfPlayerAttrs extends ComponentAttrs {
    pdfContainer: HTMLElement;
    resourceUrl: string;
}

export default class PdfPlayer<
    CustomAttrs extends PdfPlayerAttrs = PdfPlayerAttrs
> extends Component<CustomAttrs> {
    private pdfEmbed?: any;

    oncreate() {
        const { pdfContainer, resourceUrl } = this.attrs;
        this.pdfEmbed = createPdfDiv(pdfContainer, resourceUrl);
    }

    onremove() {
        if (this.pdfEmbed) {
            this.pdfEmbed = null;
        }
    }

    view() {
        return <div />;
    }
}

const createPdfDiv = (pdfContainer: HTMLElement, url: string) => {
    const options = {
        height: "440px",
        fallbackLink: `<p>${app.translator.trans(
            "gbcl-fof-upload-qcloud.forum.pdf.fallbackNotice1"
        )}: <a href='${url}'>${app.translator.trans(
            "gbcl-fof-upload-qcloud.forum.pdf.fallbackNotice2"
        )}</a></p>`,
    };

    return PDFObject.embed(url, pdfContainer, options);
}

<?php

namespace GBCLStudio\UploadExtQcloud\Templates;

use FoF\Upload\File;
use FoF\Upload\Templates\AbstractTextFormatterTemplate;
use Illuminate\Contracts\View\View;

class QcloudPdfTemplate extends AbstractTextFormatterTemplate
{
    public const templateName = 'upl-qcloud-pdf';

    /**
     * @var string
     */
    protected $tag = 'qcloud-pdf';

    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return $this->trans('gbcl-fof-upload-qcloud.admin.template.pdf.name');
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return $this->trans('gbcl-fof-upload-qcloud.admin.template.pdf.description');
    }

    /**
     * {@inheritdoc}
     */
    public function template(): View
    {
        return $this->getView('gbcl-fof-upload-qcloud.templates::qcloud-pdf');
    }

    /**
     * {@inheritdoc}
     */
    public function bbcode(): string
    {
        return '[upl-qcloud-pdf uuid={IDENTIFIER} preview_uri={URL} fullscreen_uri={URL}]';
    }

    public function preview(File $file): string
    {
        return "[upl-qcloud-pdf uuid=$file->uuid preview_uri=$file->url fullscreen_uri={URL}]";
    }
}

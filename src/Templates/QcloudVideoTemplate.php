<?php

namespace GBCLStudio\UploadExtQcloud\Templates;

use FoF\Upload\File;
use FoF\Upload\Templates\AbstractTextFormatterTemplate;

class QcloudVideoTemplate extends AbstractTextFormatterTemplate
{
    public const templateName = "upl-qcloud-video";

    /**
     * @var string
     */
    protected $tag = 'qcloud-video';

    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return $this->trans('gbcl-fof-upload-qcloud.admin.template.video-preview.name');
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return $this->trans('gbcl-fof-upload-qcloud.admin.template.video-preview.description');
    }

    /**
     * The xsl template to use with this tag.
     *
     * @return string
     */
    public function template(): string
    {
        return $this->getView('gbcl-fof-upload-qcloud.templates::qcloud-video');
    }

    /**
     * The bbcode to be parsed.
     *
     * @return string
     */
    public function bbcode(): string
    {
        return '[upl-qcloud-video uuid={IDENTIFIER} preview_uri={URL} fullscreen_uri={URL}]';
    }
    public function preview(File $file): string
    {
        return "[upl-qcloud-video uuid={$file->uuid} preview_uri={$file->url} fullscreen_uri={URL}]";
    }
}

<?php

namespace GBCLStudio\UploadExtQcloud\Templates;

use FoF\Upload\File;
use FoF\Upload\Templates\AbstractTextFormatterTemplate;

class QcloudAudioTemplate extends AbstractTextFormatterTemplate
{
    public const templateName = "upl-qcloud-audio";

    /**
     * @var string
     */
    protected $tag = 'qcloud-audio';

    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return $this->trans('gbcl-fof-upload-qcloud.admin.template.audio.name');
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return $this->trans('gbcl-fof-upload-qcloud.admin.template.audio.description');
    }

    /**
     * The xsl template to use with this tag.
     *
     * @return string
     */
    public function template(): string
    {
        return $this->getView('gbcl-fof-upload-qcloud.templates::qcloud-audio');
    }

    /**
     * The bbcode to be parsed.
     *
     * @return string
     */
    public function bbcode(): string
    {
        return '[upl-qcloud-audio uuid={IDENTIFIER} preview_uri={URL} fullscreen_uri={URL}]';
    }

    public function preview(File $file): string
    {
        return "[upl-qcloud-audio uuid={$file->uuid} preview_uri={$file->url} fullscreen_uri={URL}]";
    }

}

<?php

namespace GBCLStudio\UploadExtQcloud\Templates;

use FoF\Upload\Templates\AbstractTextFormatterTemplate;

class QcloudAudioTemplate extends AbstractTextFormatterTemplate
{
    /**
     * @var string
     */
    protected $tag = 'audio';

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
        return $this->getView('gbcl-fof-upload-qcloud.templates::Qcloud-audio');
    }

    /**
     * The bbcode to be parsed.
     *
     * @return string
     */
    public function bbcode(): string
    {
        return '[upl-qcloud-audio uuid={IDENTIFIER} size={SIMPLETEXT2} url={URL}]{SIMPLETEXT1}[/upl-audio]';
    }
}

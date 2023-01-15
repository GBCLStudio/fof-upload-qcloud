<?php

namespace GBCLStudio\UploadExtQcloud\Templates;

use FoF\Upload\Templates\AbstractTextFormatterTemplate;

class QcloudVideoTemplate extends AbstractTextFormatterTemplate
{
    /**
     * @var string
     */
    protected $tag = 'video';

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
        return $this->getView('gbcl-fof-upload-qcloud::Qcloud-video-preview');
    }

    /**
     * The bbcode to be parsed.
     *
     * @return string
     */
    public function bbcode(): string
    {
        return '[upl-qcloud-video uuid={IDENTIFIER} size={SIMPLETEXT2} url={URL}]{SIMPLETEXT1}[/upl-video]';
    }
}

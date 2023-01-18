<?php

namespace GBCLStudio\UploadExtQcloud\Templates;

use FoF\Upload\File;
use FoF\Upload\Templates\AbstractTextFormatterTemplate;

class QcloudDownloadTemplate extends AbstractTextFormatterTemplate
{
    public const templateName = "upl-qcloud-download";

    /**
     * @var string
     */
    protected $tag = 'qcloud-download';

    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return $this->trans('gbcl-fof-upload-qcloud.admin.template.download.name');
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return $this->trans('gbcl-fof-upload-qcloud.admin.template.download.description');
    }

    /**
     * {@inheritdoc}
     */
    public function template(): string
    {
        return $this->getView('gbcl-fof-upload-qcloud.templates::qcloud-download');
    }

    /**
     * {@inheritdoc}
     */
    public function bbcode(): string
    {
        return '[upl-qcloud-download uuid={IDENTIFIER} name={SIMPLETEXT} size={SIMPLETEXT2}]';
    }

    public function preview(File $file): string
    {
        return "[upl-qcloud-download uuid={$file->uuid} name={$file->base_name} size={$file->humanSize}]";
    }
}

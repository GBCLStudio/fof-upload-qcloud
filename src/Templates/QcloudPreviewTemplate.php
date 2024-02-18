<?php

namespace GBCLStudio\UploadExtQcloud\Templates;

use FoF\Upload\File;
use FoF\Upload\Templates\AbstractTextFormatterTemplate;
use Illuminate\Contracts\View\View;

class QcloudPreviewTemplate extends AbstractTextFormatterTemplate
{
    public const templateName = 'upl-qcloud-preview';

    /**
     * @var string
     */
    protected $tag = 'qcloud-preview';

    /**
     * {@inheritdoc}
     */
    public function name(): string
    {
        return $this->trans('gbcl-fof-upload-qcloud.admin.template.image-preview.name');
    }

    /**
     * {@inheritdoc}
     */
    public function description(): string
    {
        return $this->trans('gbcl-fof-upload-qcloud.admin.template.image-preview.description');
    }

    /**
     * {@inheritdoc}
     */
    public function template(): View
    {
        return $this->getView('gbcl-fof-upload-qcloud.templates::qcloud-preview');
    }

    /**
     * {@inheritdoc}
     */
    public function bbcode(): string
    {
        return '[upl-qcloud-preview uuid={IDENTIFIER} preview_uri={URL} fullscreen_uri={URL}]';
    }

    public function preview(File $file): string
    {
        return "[upl-qcloud-preview uuid=$file->uuid preview_uri=$file->url fullscreen_uri={URL}]";
    }
}

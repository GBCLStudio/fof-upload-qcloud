<?php

namespace GBCLStudio\UploadExtQcloud\Formatters;

use GBCLStudio\UploadExtQcloud\Configuration\QcloudConfiguration;
use FoF\Upload\Repositories\FileRepository;
use s9e\TextFormatter\Renderer;
use s9e\TextFormatter\Utils;

class QcloudVideoPreviewFormatter
{
    /**
     * @var FileRepository
     */
    private $files;

    /**
     * @var ImageXConfiguration
     */
    private $config;


    public function __construct(FileRepository $files, QcloudConfiguration $config)
    {
        $this->files = $files;
        $this->config = $config;
    }

    /**
     * Configure rendering for text preview uploads.
     *
     * @param Renderer $renderer
     * @param mixed $context
     * @param string $xml
     *
     * @return string $xml to be rendered
     */
    public function __invoke(Renderer $renderer, $context, string $xml)
    {
        return Utils::replaceAttributes($xml, 'UPL-QCLOUD-VIDEO-PREVIEW', function ($attributes) {
            $file = $this->files->findByUuid($attributes['uuid']);
            $attributes["preview_uri"] = $this->config->generateUrl($file);
            $attributes["fullscreen_uri"] = $this->config->generateUrl($file);
            $attributes["base_name"] = $file->base_name;
            return $attributes;
        });
    }
}

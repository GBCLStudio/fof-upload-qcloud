<?php

namespace GBCLStudio\UploadExtQcloud\Formatters;

use FoF\Upload\Repositories\FileRepository;
use GBCLStudio\UploadExtQcloud\Configuration\QcloudConfiguration;
use s9e\TextFormatter\Renderer;
use s9e\TextFormatter\Utils;

class QcloudVideoFormatter
{
    /**
     * @var FileRepository
     */
    private FileRepository $files;

    /**
     * @var QcloudConfiguration
     */
    private QcloudConfiguration $config;

    public function __construct(FileRepository $files, QcloudConfiguration $config)
    {
        $this->files = $files;
        $this->config = $config;
    }

    /**
     * Configure rendering for text preview uploads.
     *
     * @param Renderer $renderer
     * @param mixed    $context
     * @param string   $xml
     *
     * @return string $xml to be rendered
     */
    public function __invoke(Renderer $renderer, mixed $context, string $xml): string
    {
        return Utils::replaceAttributes($xml, 'UPL-QCLOUD-VIDEO', function ($attributes) {
            $file = $this->files->findByUuid($attributes['uuid']);
            $preview_url = $this->config->generateUrl($file);
            $file->url = $preview_url;
            $file->save();

            $file = $this->files->findByUuid($attributes['uuid']);
            $attributes['preview_uri'] = $preview_url;
            $attributes['base_name'] = $file->base_name;

            return $attributes;
        });
    }
}

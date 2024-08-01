<?php

namespace GBCLStudio\UploadExtQcloud\Adapters;

use Exception;
use FoF\Upload\Adapters\Flysystem;
use FoF\Upload\Contracts\UploadAdapter;
use FoF\Upload\File;
use GBCLStudio\UploadExtQcloud\Configuration\QcloudConfiguration;
use League\Flysystem\Config;
use Overtrue\Flysystem\Cos\CosAdapter;

class QcloudFofAdapter extends Flysystem implements UploadAdapter
{
    /**
     * @var array Qcloud Client Settings
     */
    private array $arrConfig;
    private QcloudConfiguration $pluginConfig;

    /**
     * @param $pluginConfig QcloudConfiguration
     */
    public function __construct($pluginConfig)
    {
        $config = new QcloudConfiguration();

        $arrConfig = [
            'region'     => $config->region,
            'app_id'     => $config->appId,
            'secret_id'  => $config->secretId,
            'secret_key' => $config->secretKey,
            'token'      => null,
            'cdn'        => $config->cdn,
            'bucket'     => $config->bucket,
            'use_https'  => $config->useHttps,
        ];
        parent::__construct(new CosAdapter($arrConfig));

        $this->arrConfig = $arrConfig;
        $this->pluginConfig = $pluginConfig;
    }

    protected function getConfig(): Config
    {
        return new Config($this->arrConfig);
    }

    /**
     * @throws Exception
     */
    protected function generateUrl(File $file): void
    {
        $file->url = $this->pluginConfig->generateUrl($file);
    }
}

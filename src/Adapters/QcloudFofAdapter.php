<?php

namespace GBCLStudio\UploadExtQcloud\Adapters;

use Exception;
use Freyo\Flysystem\QcloudCOSv5\Adapter;
use FoF\Upload\Adapters\Flysystem;
use FoF\Upload\Contracts\UploadAdapter;
use FoF\Upload\File;
use GBCLStudio\UploadExtQcloud\Configuration\QcloudConfiguration;
use League\Flysystem\Config;
use Qcloud\Cos\Client;

class QcloudFofAdapter extends Flysystem implements UploadAdapter
{
    /**
     * @var array Qcloud Client Settings
     */
    private $arrConfig;

    private QcloudConfiguration $pluginConfig;

    /**
     * @param $pluginConfig QcloudConfiguration
     */

    public function __construct($pluginConfig)
    {
        $client =  new Client($pluginConfig->QcloudConfig);
        parent::__construct(new Adapter($client, $pluginConfig->QcloudConfig));

        // Save config

        $config = $pluginConfig->QcloudConfig;

        $arrConfig = [
            'region' => $config['region'],
            'secret_Id' => $config['credentials']['secretId'],
            'secret_key' => $config['credentials']['secretKey'],
            'appId' => $config['credentials']['appId'],
            'domain' => $config['cdn'],
            'template' => $pluginConfig->imagePreviewTemplate,
        ];
        $this->arrConfig = $arrConfig;

        $this->pluginConfig = $pluginConfig;
    }

    protected function getConfig(): Client
    {
        return new Client($this->arrConfig);
    }

    /**
     * @throws Exception
     */
    protected function generateUrl(File $file)
    {
        $file->url = $this->pluginConfig->generateUrl($file);
    }
}

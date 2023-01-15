<?php

namespace GBCLStudio\UploadExtQcloud\Listeners;

use GBCLStudio\UploadExtQcloud\Adapters\QcloudFofAdapter;
use GBCLStudio\UploadExtQcloud\Configuration\QcloudConfiguration;
use FoF\Upload\Events\Adapter\Instantiate;

class AdapterInstantiateListener
{
    protected QcloudConfiguration $config;

    public function __construct(QcloudConfiguration $config)
    {
        $this->config = $config;
    }

    public function handle(Instantiate $event): ?QcloudFofAdapter
    {
        if ($event->adapter != 'qcloud') {
            return null;
        }

        return new QcloudFofAdapter($this->config);
    }
}

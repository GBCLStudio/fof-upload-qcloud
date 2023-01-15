<?php

namespace GBCLStudio\UploadExtQcloud\Providers;

use GBCLStudio\UploadExtQcloud\Configuration\QcloudConfiguration;
use GBCLStudio\UploadExtQcloud\Templates\QcloudAudioTemplate;
use GBCLStudio\UploadExtQcloud\Templates\QcloudVideoTemplate;
use Flarum\Foundation\AbstractServiceProvider;
use FoF\Upload\Helpers\Util;

class QcloudProvider extends AbstractServiceProvider
{
    public function register()
    {
        $this->container->singleton(QcloudConfiguration::class);

        /** @var Util $util */
        $util = $this->container->make(Util::class);

        $util->addRenderTemplate($this->container->make(QcloudAudioTemplate::class));
        $util->addRenderTemplate($this->container->make(QcloudVideoTemplate::class));
    }
}

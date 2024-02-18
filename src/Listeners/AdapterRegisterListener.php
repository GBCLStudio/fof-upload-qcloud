<?php

namespace GBCLStudio\UploadExtQcloud\Listeners;

use FoF\Upload\Events\Adapter\Collecting;

class AdapterRegisterListener
{
    public function __construct()
    {
    }

    public function handle(Collecting $event)
    {
        $event->adapters['qcloud'] = true;
    }
}

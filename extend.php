<?php

/*
 * This file is part of gbcl/fof-upload-ext-qcloud.
 *
 * Copyright (c) 2023 GBCLStudio.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace GBCLStudio\UploadExtQcloud;

use GBCLStudio\UploadExtQcloud\Formatters\PreviewFormatter;
use GBCLStudio\UploadExtQcloud\Listeners\AdapterInstantiateListener;
use GBCLStudio\UploadExtQcloud\Listeners\AdapterRegisterListener;
use GBCLStudio\UploadExtQcloud\Providers\QcloudProvider;
use Flarum\Extend;
use FoF\Upload\Events\Adapter\Collecting;
use FoF\Upload\Events\Adapter\Instantiate;

return [
    (new Extend\Event)
        ->listen(Collecting::class, AdapterRegisterListener::class)
        ->listen(Instantiate::class, AdapterInstantiateListener::class),

    (new Extend\Frontend('admin'))
        ->js(__DIR__ . '/js/dist/admin.js'),

    new Extend\Locales(__DIR__ . '/resources/locale'),

    (new Extend\View())
        ->namespace('gbcl-fof-upload-qcloud.templates', __DIR__ . '/resources/templates'),

    (new Extend\ServiceProvider())
        ->register(QcloudProvider::class),
];


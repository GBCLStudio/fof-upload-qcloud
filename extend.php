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

use Flarum\Api\Serializer\PostSerializer;
use Flarum\Extend;
use FoF\Upload\Events\Adapter\Collecting;
use FoF\Upload\Events\Adapter\Instantiate;
use GBCLStudio\UploadExtQcloud\Formatters\QcloudAudioFormatter;
use GBCLStudio\UploadExtQcloud\Formatters\QcloudDownloadFormatter;
use GBCLStudio\UploadExtQcloud\Formatters\QcloudPdfFormatter;
use GBCLStudio\UploadExtQcloud\Formatters\QcloudPreviewFormatter;
use GBCLStudio\UploadExtQcloud\Formatters\QcloudVideoFormatter;
use GBCLStudio\UploadExtQcloud\Listeners\AdapterInstantiateListener;
use GBCLStudio\UploadExtQcloud\Listeners\AdapterRegisterListener;
use GBCLStudio\UploadExtQcloud\Providers\QcloudProvider;

return [
    (new Extend\Routes('api'))
        ->get('/gbcl/fof-qcloud/download/{uuid}/{post}/{csrf}', 'gbcl-fof-qcloud.download', Api\Controllers\DownloadController::class),

    (new Extend\Event())
        ->listen(Collecting::class, AdapterRegisterListener::class)
        ->listen(Instantiate::class, AdapterInstantiateListener::class),

    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js'),

    (new Extend\Frontend('forum'))
        ->js(__DIR__.'/js/dist/forum.js'),

    new Extend\Locales(__DIR__.'/resources/locale'),

    (new Extend\View())
        ->namespace('gbcl-fof-upload-qcloud.templates', __DIR__.'/resources/templates'),

    (new Extend\ApiSerializer(PostSerializer::class))
        ->attributes(Extenders\AddCurrentPostAttributes::class),

    (new Extend\ServiceProvider())
        ->register(QcloudProvider::class),

    (new Extend\Formatter())
        ->render(QcloudVideoFormatter::class)
        ->render(QcloudAudioFormatter::class)
        ->render(QcloudDownloadFormatter::class)
        ->render(QcloudPreviewFormatter::class)
        ->render(QcloudPdfFormatter::class),
];

<?php

namespace GBCLStudio\UploadExtQcloud\Extenders;

use Exception;
use Flarum\Api\Serializer\PostSerializer;
use Flarum\Post\Post;
use FoF\Upload\Repositories\FileRepository;
use GBCLStudio\UploadExtQcloud\Configuration\QcloudConfiguration;
use GBCLStudio\UploadExtQcloud\Templates\QcloudAudioTemplate;
use GBCLStudio\UploadExtQcloud\Templates\QcloudDownloadTemplate;
use GBCLStudio\UploadExtQcloud\Templates\QcloudPdfTemplate;
use GBCLStudio\UploadExtQcloud\Templates\QcloudPreviewTemplate;
use GBCLStudio\UploadExtQcloud\Templates\QcloudVideoTemplate;
use Illuminate\Support\Str;

class AddCurrentPostAttributes
{
    /**
     * @var QcloudConfiguration
     */
    private QcloudConfiguration $config;

    /**
     * @var FileRepository
     */
    private FileRepository $file;

    public function __construct(QcloudConfiguration $config, FileRepository $file)
    {
        $this->config = $config;
        $this->file = $file;
    }

    /**
     * @throws Exception
     */
    public function __invoke(PostSerializer $serializer, Post $post, array $attributes): array
    {
        $actor = $serializer->getActor();

        if ($actor->id != $post->user_id || !isset($attributes['content'])) {
            return $attributes;
        }

        if (!isset($attributes['contentType']) || ($attributes['contentType'] !== 'comment')) {
            return $attributes;
        }

        $content = $attributes['content'];
        $content = $this->replaceQcloudBBCode($content);
        $attributes['content'] = $content;

        return $attributes;
    }

    /**
     * @param $content
     *
     * @throws Exception
     *
     * @return string
     */
    private function replaceQcloudBBCode($content): string
    {
        $regexpr = '/\[upl-qcloud-((video|audio|download|pdf)-)?preview [^]]+]/i';

        return preg_replace_callback($regexpr, function ($s) {
            $s = $s[0];

            if (Str::startsWith($s, '[upl-qcloud-preview ')) {
                $feature = QcloudPreviewTemplate::templateName;
            } elseif (Str::startsWith($s, '[upl-qcloud-video ')) {
                $feature = QcloudVideoTemplate::templateName;
            } elseif (Str::startsWith($s, '[upl-qcloud-audio ')) {
                $feature = QcloudAudioTemplate::templateName;
            } elseif (Str::startsWith($s, '[upl-qcloud-download ')) {
                $feature = QcloudDownloadTemplate::templateName;
            } elseif (Str::startsWith($s, '[upl-qcloud-pdf ')) {
                $feature = QcloudPdfTemplate::templateName;
            } else {
                return '';
            }

            $kvs = array_filter(explode(' ', $s), function ($it) {
                return Str::contains($it, '=');
            });
            $uuid = false;

            foreach ($kvs as $item) {
                if (Str::startsWith($item, 'uuid=')) {
                    $uuid = substr($item, 5);
                }
            }

            if ($uuid === false) {
                return '';
            }

            $file = $this->file->findByUuid($uuid);
            if ($file == null) {
                return '';
            }

            $uuid = $file->uuid;
            $filename = $file->base_name;
            $fullscreenUri = 'place-holder';

            if ($feature == QcloudPreviewTemplate::templateName) {
                $previewUri = $this->config->generateUrl($file);
                $fullscreenUri = $this->config->generateUrl($file);

                return "[${feature} uuid=${uuid} preview_uri=${previewUri} fullscreen_uri=${fullscreenUri}]";
            } elseif ($feature == QcloudVideoTemplate::templateName) {
                $previewUri = $this->config->generateUrl($file);

                return "[${feature} uuid=${uuid} preview_uri=${previewUri} fullscreen_uri=${fullscreenUri} base_name=${filename}]";
            } elseif ($feature == QcloudAudioTemplate::templateName) {
                $previewUri = $this->config->generateUrl($file);

                return "[${feature} uuid=${uuid} preview_uri=${previewUri} fullscreen_uri=${fullscreenUri} base_name=${filename}]";
            } elseif ($feature == QcloudDownloadTemplate::templateName) {
                $size = $file->humanSize;

                return "[$feature uuid={$file->uuid} name=${filename} size={$size}]";
            } elseif ($feature == QcloudPdfTemplate::templateName) {
                $previewUri = $this->config->generateUrl($file);

                return "[${feature} uuid=${uuid} preview_uri=${previewUri} fullscreen_uri=${fullscreenUri} base_name=${filename}]";
            } else {
                return '';
            }
        }, $content);
    }
}

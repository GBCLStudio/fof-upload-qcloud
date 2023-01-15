<?php

namespace GBCLStudio\UploadExtQcloud\Configuration;

use bigDream\CdnUrlAuth\Tencent;
use Exception;
use Flarum\Settings\SettingsRepositoryInterface;
use FoF\Upload\File;

class QcloudConfiguration
{

    public array $QcloudConfig;

    /**
     * @var string
     */
    private $fileSignatureToken;


    public function __construct(SettingsRepositoryInterface $settings)
    {
        $config = [
            'region' => $settings->get('gbcl-fof-upload-qcloud.qcloudConfig.region', 'ap-beijing'),
            'credentials' => [
                'secretId' => $settings->get('gbcl-fof-upload-qcloud.qcloudConfig.secretId'),
                'secretKey' => $settings->get('gbcl-fof-upload-qcloud.qcloudConfig.secretKey'),
                'appId '=> $settings->get('gbcl-fof-upload-qcloud.qcloudConfig.appId')
            ],
            'cdn' => $settings->get('gbcl-fof-upload-qcloud.qcloudConfig.domain'),
            'bucket' => $settings->get('gbcl-fof-upload-qcloud.qcloudConfig.bucket'),
        ];
        if ($config['region'] == null || strlen($config['region']) == 0) {
            $config['region'] = 'ap-beijing';
        }
        $this->fileSignatureToken = $settings->get('gbcl-fof-upload-qcloud.qcloudConfig.SignatureToken', '');

        $this->QcloudConfig = $config;
    }

    /**
     * @param $ret
     * @return string
     */
    private function read_template($ret): string
    {
        if (!is_string($ret)) {
            $ret = '';
        }

        if (strlen($ret) == 0) {
            return '';
        }

        if (!str_starts_with($ret, '~')) {
            $ret = '~' . $ret;
        }

        if (!str_contains($ret, '.')) {
            $ret .= '.image';
        }

        return $ret;
    }

    /**
     * @return bool
     */
    public function needSignature(): bool
    {
        return $this->fileSignatureToken != null && strlen($this->fileSignatureToken) > 0;
    }

    /**
     * @param $signPath string
     * @return string
     * @throws Exception
     */
    public function signPath(string $signPath): string
    {
        $auth = new Tencent(
            $this->fileSignatureToken,
            'sign',
            't',
            false
        );

        return $auth->typeA($signPath);
    }

    /**
     * @param $file File
     * @param $template string
     * @return string
     * @throws Exception
     */
    public function generateUrl(File $file, string $template): string
    {
        if ($this->needSignature()) {
            return "//" . $this->signPath('/' . $file->path);
        } else {
            return "//" . $this->QcloudConfig['domain'] . '/' . $file->path;
        }
    }
}

<?php

namespace GBCLStudio\UploadExtQcloud\Configuration;

use bigDream\CdnUrlAuth\Tencent;
use Exception;
use Flarum\Settings\SettingsRepositoryInterface;
use FoF\Upload\File;

class QcloudConfiguration
{
    /**
     * @var string
     */
    public string $fileSignatureToken;
    public string $region;
    public string $secretId;
    public string $secretKey;
    public string $appId;
    public string $cdn;
    public string $bucket;
    public string $useHttps;
    public string $fileSignatureTokenName;
    public $fileSignatureTime;

    public function __construct()
    {
        /**
         * @var SettingsRepositoryInterface $settings
         */
        $settings = app(SettingsRepositoryInterface::class);

        $this->region = $settings->get('gbcl-fof-upload-qcloud.qcloudConfig.region', 'ap-beijing');
        $this->secretId = $settings->get('gbcl-fof-upload-qcloud.qcloudConfig.secretId');
        $this->secretKey = $settings->get('gbcl-fof-upload-qcloud.qcloudConfig.secretKey');
        $this->appId = $settings->get('gbcl-fof-upload-qcloud.qcloudConfig.appId');
        $this->cdn = $settings->get('gbcl-fof-upload-qcloud.qcloudConfig.domain');
        $this->bucket = $settings->get('gbcl-fof-upload-qcloud.qcloudConfig.bucket');
        $this->useHttps = $settings->get('gbcl-fof-upload-qcloud.qcloudConfig.useHttps', 'disableTls');
        $this->fileSignatureToken = $settings->get('gbcl-fof-upload-qcloud.qcloudConfig.fileRetrievingSignatureToken', '');
        $this->fileSignatureTokenName = $settings->get('gbcl-fof-upload-qcloud.qcloudConfig.fileRetrievingSignatureTokenName', 'sign');
        $this->fileSignatureTime = $settings->get('gbcl-fof-upload-qcloud.qcloudConfig.fileRetrievingSignatureTime', '1800');

        if ($this->region == null || strlen($this->region) == 0) {
            $this->region = 'ap-beijing';
        }
        if ($this->fileSignatureTime == null || $this->fileSignatureTime == 0) {
            $this->fileSignatureTime = '1800';
        }
        if ($this->useHttps == 'enableTls') {
            $this->useHttps = 'true';
        } else {
            $this->useHttps = 'false';
        }
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
     *
     * @throws Exception
     *
     * @return string
     */
    public function signPath(string $signPath): string
    {
        $auth = new Tencent(
            $this->fileSignatureToken,
            $this->fileSignatureTokenName,
            't',
            false
        );
        $time = time() + $this->fileSignatureTime;

        return $auth->typeA($signPath, $time);
    }

    /**
     * @param $file File
     *
     * @throws Exception
     *
     * @return string
     */
    public function generateUrl(File $file): string
    {
        if ($this->needSignature()) {
            return $this->cdn.$this->signPath('/'.$file->path);
        } else {
            return $this->cdn.'/'.$file->path;
        }
    }
}

<?php

namespace GBCLStudio\UploadExtQcloud\Configuration;

use bigDream\CdnUrlAuth\Tencent;
use Exception;
use Flarum\Settings\SettingsRepositoryInterface;
use FoF\Upload\File;
use FoF\Upload\Helpers\Util;

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

    public function __construct(private SettingsRepositoryInterface $settings, private Util $util)
    {
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

        $this->region = (empty($this->region)) ? 'ap-beijing' : $this->region;
        $this->fileSignatureTime = ($this->fileSignatureTime === null || $this->fileSignatureTime === 0) ? '1800' : $this->fileSignatureTime;
        $this->useHttps = ($this->useHttps === 'enableTls') ? 'true' : 'false';
    }

    /**
     * @return bool
     */
    public function needSignature(): bool
    {
        return $this->fileSignatureToken != null && strlen($this->fileSignatureToken) > 0;
    }

    public function isAdapterAndTemplateEnabled(): bool
    {
        $mimeTypesConfig = $this->util->getMimeTypesConfiguration();
        return $mimeTypesConfig->filter(function ($item) {
            return is_array($item) &&
                   isset($item['adapter'], $item['template']) &&
                   strpos($item['adapter'], 'qcloud') !== false &&
                   strpos($item['template'], 'qcloud-') === 0;
        })->isNotEmpty();
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
            if (!$this->isAdapterAndTemplateEnabled()) throw new \InvalidArgumentException('You need to enable adapter and template for qcloud');
            return $this->cdn.$this->signPath('/'.$file->path);
        } else {
            return $this->cdn.'/'.$file->path;
        }
    }
}

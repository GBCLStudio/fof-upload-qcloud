<?php

namespace GBCLStudio\UploadExtQcloud\Api\Controllers;

use Exception;
use Flarum\Post\PostRepository;
use Flarum\Settings\SettingsRepositoryInterface;
use FoF\Upload\Api\Serializers\FileSerializer;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Session\Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\RedirectResponse;
use GBCLStudio\UploadExtQcloud\Configuration\QcloudConfiguration;
use FoF\Upload\Repositories\FileRepository;

class DownloadController implements RequestHandlerInterface
{
    public $serializer = FileSerializer::class;

    /**
     * @var Dispatcher
     */
    protected $bus;

    /**
     * @var PostRepository
     */
    private $posts;

    /**
     * @var SettingsRepositoryInterface
     */
    private $settings;

    /**
     * @var FileRepository
     */
    private $files;

    /**
     * @var QcloudConfiguration
     */
    private QcloudConfiguration $QcloudConfig;

    public function __construct(Dispatcher $bus, PostRepository $posts, SettingsRepositoryInterface $settings, FileRepository $files, QcloudConfiguration $QcloudConfig)
    {
        $this->bus = $bus;
        $this->posts = $posts;
        $this->settings = $settings;
        $this->files = $files;
        $this->QcloudConfig = $QcloudConfig;
    }

    /**
     * @throws Exception
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $actor = $request->getAttribute('actor');
        $uuid = Arr::get($request->getQueryParams(), 'uuid');
        $postId = Arr::get($request->getQueryParams(), 'post');
        $csrf = Arr::get($request->getQueryParams(), 'csrf');

        $post = $this->posts->findOrFail($postId, $actor);
        $discussion = $post->discussion_id;
        /** @var Session $session */
        $session = $request->getAttribute('session');
        if ($this->settings->get('fof-upload.disableHotlinkProtection') != 1 && $csrf !== $session->token()) {
            throw new ModelNotFoundException();
        }

        $file = $this->files->findByUuid($uuid);
        if ($file == null) {
            throw new ModelNotFoundException();
        }

        $url = $this->QcloudConfig->generateUrl($file);
        return new RedirectResponse($url);
    }
}

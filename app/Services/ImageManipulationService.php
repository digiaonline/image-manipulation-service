<?php

namespace Nord\ImageManipulationService\Services;

use GuzzleHttp\Client as GuzzleClient;
use League\Flysystem\FilesystemInterface;
use League\Glide\Server;
use Nord\ImageManipulationService\Exceptions\ImageUploadException;
use Nord\ImageManipulationService\Helpers\FilePathHelper;
use Nord\ImageManipulationService\Helpers\MimeTypeHelper;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ImageManipulationService
 * @package Nord\ImageManipulationService\Services
 */
class ImageManipulationService
{

    /**
     * @var Server
     */
    private $glideServer;

    /**
     * @var PresetService
     */
    private $presetService;

    /**
     * @var FilePathHelper
     */
    private $filePathHelper;

    /**
     * @var GuzzleClient
     */
    private $guzzleClient;

    /**
     * @var MimeTypeHelper
     */
    private $mimeTypeHelper;


    /**
     * ImageManipulationService constructor.
     *
     * @param Server         $glideServer
     * @param PresetService  $presetService
     * @param FilePathHelper $filePathHelper
     * @param GuzzleClient   $guzzleClient
     * @param MimeTypeHelper $mimeTypeHelper
     */
    public function __construct(
        Server $glideServer,
        PresetService $presetService,
        FilePathHelper $filePathHelper,
        GuzzleClient $guzzleClient,
        MimeTypeHelper $mimeTypeHelper
    ) {
        $this->glideServer    = $glideServer;
        $this->presetService  = $presetService;
        $this->filePathHelper = $filePathHelper;
        $this->guzzleClient   = $guzzleClient;
        $this->mimeTypeHelper = $mimeTypeHelper;
    }


    /**
     * Returns the CDN base URL if defined, otherwise null
     *
     * @return string|null
     */
    public function getCdnBaseUrl(): ?string
    {
        $url = env('CDN_BASEURL');

        return !empty($url) ? $url : null;
    }


    /**
     * @param string $path
     * @param string $preset
     *
     * @return Response
     */
    public function getPresetImageResponse(string $path, string $preset): Response
    {
        $params = $this->presetService->getPresetParameters($preset);

        return $this->glideServer->getImageResponse($path, $params);
    }


    /**
     * @param string $path
     *
     * @return Response
     */
    public function getOriginalImageResponse(string $path): Response
    {
        // Bypass Glide and return the image from the source filesystem directly
        $sourceFilesystem = $this->glideServer->getSource();

        return $this->glideServer->getResponseFactory()->create($sourceFilesystem, $path);
    }


    /**
     * @param string $path
     * @param array  $parameters
     *
     * @return Response
     */
    public function getCustomImageResponse(string $path, array $parameters): Response
    {
        return $this->glideServer->getImageResponse($path, $parameters);
    }


    /**
     * Stores the uploaded file with the specified path. The filename and extension is taken from the uploaded file.
     *
     * @param UploadedFile $file
     * @param string       $path
     * @param string|null  $mimeType
     *
     * @return string
     */
    public function storeUploadedFile(UploadedFile $file, string $path, ?string $mimeType = null): string
    {
        // Get stream to the file contents
        $stream = $this->getStreamFromFile($file->getRealPath());

        // Determine the path to the file
        $filePath = $this->filePathHelper->determineFilePath($path,
            $file->getClientOriginalName(),
            $file->getClientOriginalExtension());

        // Store
        $this->storeFileFromStream($filePath, $stream, $mimeType);

        return $filePath;
    }


    /**
     * Stores the file from the specified URL, using the specified path and filename
     *
     * @param string      $url
     * @param string      $path
     * @param string      $filename
     * @param string|null $mimeType
     *
     * @return string
     */
    public function storeUrlFile($url, string $path, string $filename, ?string $mimeType = null): string
    {
        // Get stream to the file contents
        $stream = $this->getStreamFromUrl($url);

        // Determine the path to the file
        $filePath = $this->filePathHelper->determineFilePath($path,
            $filename,
            $this->filePathHelper->getFileExtension($filename));

        // Store
        $this->storeFileFromStream($filePath, $stream, $mimeType);

        return $filePath;
    }


    /**
     * @return int
     */
    public function getStoredImagesCount(): int
    {
        return count($this->getFilesystem()->listContents('/', true));
    }


    /**
     * @return FilesystemInterface
     */
    private function getFilesystem(): FilesystemInterface
    {
        return $this->glideServer->getSource();
    }


    /**
     * Attempts to open a resource to the file at the specified path
     *
     * @param string $filePath
     *
     * @return resource
     *
     * @throws ImageUploadException
     */
    private function getStreamFromFile(string $filePath)
    {
        $stream = fopen($filePath, 'r+');

        if ($stream === false) {
            throw new ImageUploadException('Failed to open stream to uploaded file');
        }

        return $stream;
    }


    /**
     * Attempts to grab the contents of the specified URL and return it as a stream resource
     *
     * @param string $url
     *
     * @return resource
     *
     * @throws ImageUploadException
     */
    private function getStreamFromUrl(string $url)
    {
        // Try to grab the response body stream as a resource
        try {
            $response = $this->guzzleClient->get($url);

            return $response->getBody()->detach();
        } catch (\Exception $e) {
            throw new ImageUploadException('Failed to retrieve image from URL: ' . $e->getMessage(), $e);
        }
    }


    /**
     * Attempts to store the specified stream as a file at the specified file path
     *
     * @param string      $filePath
     * @param resource    $stream
     * @param string|null $mimeType
     *
     * @throws ImageUploadException
     */
    private function storeFileFromStream(string $filePath, $stream, ?string $mimeType = null)
    {
        try {
            $config = [];

            // Try to determine the MIME type if it isn't specified
            $mimeType = $mimeType ?? $this->mimeTypeHelper->guessMimeTypeFromStream($stream);

            if ($mimeType !== null) {
                // League-specific thing, will get converted to the right options down the line
                $config['mimetype'] = $mimeType;
            }

            $this->getFilesystem()->writeStream($filePath, $stream, $config);
            fclose($stream);
        } catch (\Exception $e) {
            throw new ImageUploadException('Failed to upload image: ' . $e->getMessage(), $e);
        }
    }

}

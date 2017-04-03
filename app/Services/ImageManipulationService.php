<?php

namespace Nord\ImageManipulationService\Services;

use League\Flysystem\FilesystemInterface;
use League\Glide\Server;
use Nord\ImageManipulationService\Exceptions\ImageUploadException;
use Nord\ImageManipulationService\Helpers\FilePathHelper;
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
     * ImageManipulationService constructor.
     *
     * @param Server         $glideServer
     * @param PresetService  $presetService
     * @param FilePathHelper $filePathHelper
     */
    public function __construct(Server $glideServer, PresetService $presetService, FilePathHelper $filePathHelper)
    {
        $this->glideServer    = $glideServer;
        $this->presetService  = $presetService;
        $this->filePathHelper = $filePathHelper;
    }


    /**
     * Returns the CDN base URL if defined, otherwise null
     *
     * @return string|null
     */
    public function getCdnBaseUrl()
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
        return $this->glideServer->getImageResponse($path, []);
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
     * @param UploadedFile $file
     * @param string       $path
     *
     * @return string
     * @throws ImageUploadException
     */
    public function storeUploadedFile(UploadedFile $file, string $path): string
    {
        $stream = fopen($file->getRealPath(), 'r+');

        if ($stream === false) {
            throw new ImageUploadException('Failed to open stream to uploaded file');
        }

        // Determine the path to the file
        $filePath = $this->filePathHelper->determineFilePath($path,
            $file->getClientOriginalName(),
            $file->getClientOriginalExtension());

        // Try to save the file, re-throw exceptions as ImageUploadException
        try {
            $this->getFilesystem()->writeStream($filePath, $stream);
            fclose($stream);
        } catch (\Exception $e) {
            throw new ImageUploadException('Failed to upload image: ' . $e->getMessage(), $e);
        }

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

}

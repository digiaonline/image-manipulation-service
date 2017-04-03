<?php

namespace Nord\ImageManipulationService\Services;

use League\Glide\Server;
use Nord\ImageManipulationService\Exceptions\ImageUploadException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ImageManipulationService
 * @package Nord\ImageManipulationService\Services
 */
class ImageManipulationService
{

    const FILENAME_POSTFIX_LENGTH = 5;

    /**
     * @var Server
     */
    private $glideServer;

    /**
     * @var PresetService
     */
    private $presetService;


    /**
     * ImageManipulationService constructor.
     *
     * @param Server        $glideServer
     * @param PresetService $presetService
     */
    public function __construct(Server $glideServer, PresetService $presetService)
    {
        $this->glideServer   = $glideServer;
        $this->presetService = $presetService;
    }


    /**
     * @return string|null
     */
    public function getCdnBaseUrl()
    {
        return env('CDN_BASEURL', null);
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

        $filePath = $this->determineFilePath($path, $file);

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
     * @param string       $prefix
     * @param UploadedFile $file
     *
     * @return string
     */
    private function determineFilePath(string $prefix, UploadedFile $file): string
    {
        $prefix    = trim($prefix, '/');
        $filename  = $this->getFilenameWithoutExtension($file->getClientOriginalName());
        $hash      = str_random(self::FILENAME_POSTFIX_LENGTH);
        $extension = $file->getClientOriginalExtension();

        return "{$prefix}/{$filename}_{$hash}.{$extension}";
    }


    /**
     * @return \League\Flysystem\FilesystemInterface
     */
    private function getFilesystem()
    {
        return $this->glideServer->getSource();
    }


    /**
     * @param string $filename
     *
     * @return string
     */
    private function getFilenameWithoutExtension(string $filename): string
    {
        return substr($filename, 0, (strrpos($filename, '.')));
    }

}

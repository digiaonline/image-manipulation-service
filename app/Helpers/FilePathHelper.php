<?php

namespace Nord\ImageManipulationService\Helpers;

/**
 * Class FilePathHelper
 * @package Nord\ImageManipulationService\Helpers
 */
class FilePathHelper
{

    const FILENAME_POSTFIX_LENGTH = 5;


    /**
     * @param string $prefix
     * @param string $clientOriginalName
     * @param string $clientOriginalExtension
     *
     * @return string
     */
    public function determineFilePath(
        string $prefix,
        string $clientOriginalName,
        string $clientOriginalExtension
    ): string {
        $prefix    = trim($prefix, '/');
        $filename  = $this->getFilenameWithoutExtension($clientOriginalName);
        $hash      = $this->getRandomPostfix();
        $extension = $clientOriginalExtension;

        // Don't include an empty prefix
        if (empty($prefix)) {
            return "{$filename}_{$hash}.{$extension}";
        } else {
            return "{$prefix}/{$filename}_{$hash}.{$extension}";
        }
    }


    /**
     * @param string $filename
     *
     * @return string
     */
    public function getFileExtension(string $filename): string
    {
        $pathInfo = pathinfo($filename);

        return isset($pathInfo['extension']) ? $pathInfo['extension'] : '';
    }


    /**
     * @return string
     */
    protected function getRandomPostfix(): string
    {
        return str_random(self::FILENAME_POSTFIX_LENGTH);
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

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

        return "{$prefix}/{$filename}_{$hash}.{$extension}";
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

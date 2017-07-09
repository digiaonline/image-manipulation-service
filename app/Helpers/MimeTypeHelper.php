<?php

namespace Nord\ImageManipulationService\Helpers;

use League\Flysystem\Util;
use Nord\ImageManipulationService\Exceptions\BaseException;

/**
 * Class MimeTypeHelper
 * @package Nord\ImageManipulationService\Helpers
 */
class MimeTypeHelper
{

    /**
     * The number of bytes to scan from the stream
     */
    const BYTES_TO_READ = 1024;


    /**
     * @param resource $stream a readable and seekable stream
     *
     * @return string|null the guessed MIME type, or null if not guessable
     */
    public function guessMimeTypeFromStream($stream)
    {
        $mimeType = null;

        // Read the header from the stream into a temporary file
        $header   = $this->readAndRewind($stream);
        $filePath = $this->getTemporaryFilePath();

        if (file_put_contents($filePath, $header) !== false) {
            // Attempt to guess the MIME type
            $fileContents = file_get_contents($filePath);

            if ($fileContents !== false) {
                $mimeType = Util::guessMimeType($filePath, file_get_contents($filePath));
            }
        }

        // Remove the temporary file we just created
        unlink($filePath);

        return $mimeType;
    }


    /**
     * @param resource $stream
     *
     * @return bool|string
     */
    private function readAndRewind($stream)
    {
        $header = fread($stream, self::BYTES_TO_READ);

        if ($header !== false) {
            fseek($stream, 0);
        }

        return $header;
    }


    /**
     * @return string
     *
     * @throws BaseException
     */
    private function getTemporaryFilePath(): string
    {
        $filePath = tempnam(sys_get_temp_dir(), 'ImageManipulationService');

        if ($filePath === false) {
            throw new BaseException('Failed to create temporary file');
        }

        return $filePath;
    }

}

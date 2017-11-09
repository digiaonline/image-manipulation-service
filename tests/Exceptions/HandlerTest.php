<?php

namespace Nord\ImageManipulationService\Tests\Exceptions;

use League\Flysystem\FileNotFoundException;
use Nord\ImageManipulationService\Exceptions\Handler;
use Nord\ImageManipulationService\Tests\TestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class HandlerTest
 * @package Nord\ImageManipulationService\Tests\Exceptions
 */
class HandlerTest extends TestCase
{

    /**
     * Tests that the exception is converted
     */
    public function testFileNotFoundException()
    {
        $handler  = new Handler();
        $response = $handler->render(null, new FileNotFoundException('/'));

        $data = json_decode((string)$response->getContent(), true);

        $this->assertEquals(NotFoundHttpException::class, $data['exception']);
    }

    /**
     * Tests that exceptions are rendered as JSON
     */
    public function testHandleRender()
    {
        $handler  = new Handler();
        $response = $handler->render(null, new \InvalidArgumentException('The message', 23));

        $data = json_decode((string)$response->getContent(), true);

        $this->assertArraySubset([
            'exception' => 'InvalidArgumentException',
            'message'   => 'The message',
            'code'      => 23,
        ], $data);

        $this->assertEquals(env('APP_DEBUG'), array_key_exists('trace', $data));
    }

}

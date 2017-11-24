<?php

namespace Nord\ImageManipulationService\Tests\Exceptions;

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
     * Tests that some exception is converted and that the correct HTTP status code is used
     *
     * @dataProvider fileNotFoundExceptionProvider
     *
     * @param \Exception $e
     */
    public function testFileNotFoundException(\Exception $e)
    {
        $handler  = new Handler();
        $response = $handler->render(null, $e);

        $data = json_decode((string)$response->getContent(), true);

        $this->assertEquals(NotFoundHttpException::class, $data['exception']);
        $this->assertEquals(404, $response->getStatusCode());
    }

    /**
     * Tests that HTTP 500 is returned normally when an exception is rendered
     */
    public function testNormalException()
    {
        $handler  = new Handler();
        $response = $handler->render(null, new \InvalidArgumentException('Some error'));

        $this->assertEquals(500, $response->getStatusCode());
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

    /**
     * @return array
     */
    public function fileNotFoundExceptionProvider(): array
    {
        return [
            [new \League\Flysystem\FileNotFoundException('/')],
            [new \League\Glide\Filesystem\FileNotFoundException('/')],
        ];
    }

}

<?php

namespace Nord\ImageManipulationService\Tests\Exceptions;

use Nord\ImageManipulationService\Exceptions\Handler;
use Nord\ImageManipulationService\Tests\TestCase;

/**
 * Class HandlerTest
 * @package Nord\ImageManipulationService\Tests\Exceptions
 */
class HandlerTest extends TestCase
{

    public function testHandle()
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

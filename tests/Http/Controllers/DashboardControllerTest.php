<?php

namespace Nord\ImageManipulationService\Tests\Http\Controllers;

use Nord\ImageManipulationService\Tests\TestCase;

/**
 * Class DashboardControllerTest
 * @package Nord\ImageManipulationService\Tests\Http\Controllers
 */
class DashboardControllerTest extends TestCase
{

    /**
     * Tests that the dashboard is accessible when it's enabled
     */
    public function testDashboardWhenEnabled()
    {
        putenv('DASHBOARD_ENABLED=true');

        $response = $this->call('GET', '/');

        $this->assertEquals(200, $response->getStatusCode());
    }


    /**
     * Tests that the dashboard is not accessible when it's disabled
     */
    public function testDashboardWhenDisabled()
    {
        putenv('DASHBOARD_ENABLED=false');

        $response = $this->call('GET', '/');

        $this->assertEquals(403, $response->getStatusCode());
    }

}

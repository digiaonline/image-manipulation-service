<?php

namespace Nord\ImageManipulationService\Http\Controllers;

use Illuminate\Http\Response;

/**
 * Class HealthCheckController
 * @package Nord\ImageManipulationService\Http\Controllers
 */
class HealthCheckController extends Controller
{

    /**
     * @return Response
     */
    public function index(): Response
    {
        return new Response('OK');
    }

}

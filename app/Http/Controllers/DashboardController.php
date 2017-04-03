<?php

namespace Nord\ImageManipulationService\Http\Controllers;

use Illuminate\Contracts\View\View;
use Nord\ImageManipulationService\Services\ImageManipulationService;

/**
 * Class DashboardController
 * @package Nord\ImageManipulationService\Http\Controllers
 */
class DashboardController extends Controller
{

    /**
     * @var ImageManipulationService
     */
    private $imageManipulationService;


    /**
     * DashboardController constructor.
     *
     * @param ImageManipulationService $imageManipulationService
     */
    public function __construct(ImageManipulationService $imageManipulationService)
    {
        $this->imageManipulationService = $imageManipulationService;
    }


    /**
     * Displays the dashboard
     *
     * @return View
     */
    public function dashboard(): View
    {
        return view('dashboard.dashboard', [
            'storedImagesCount' => $this->imageManipulationService->getStoredImagesCount(),
            'cdnBaseUrl'        => env('CDN_BASEURL', null),
        ]);
    }

}

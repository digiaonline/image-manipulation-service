<?php

namespace Nord\ImageManipulationService\Http\Controllers;

use Illuminate\Contracts\View\View;

/**
 * Class DashboardController
 * @package Nord\ImageManipulationService\Http\Controllers
 */
class DashboardController extends Controller
{

    /**
     * Displays the dashboard
     *
     * @return View
     */
    public function dashboard(): View
    {
        return view('dashboard.dashboard');
    }

}

<?php

namespace Nord\ImageManipulationService\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Nord\ImageManipulationService\Helpers\UriHelper;
use Nord\ImageManipulationService\Services\ImageManipulationService;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ImageController
 * @package Nord\ImageManipulationService\Http\Controllers
 */
class ImageController extends Controller
{

    /**
     * @var ImageManipulationService
     */
    private $imageManipulationService;

    /**
     * @var UriHelper
     */
    private $uriHelper;


    /**
     * ImageController constructor.
     *
     * @param ImageManipulationService $imageManipulationService
     * @param UriHelper                $uriHelper
     */
    public function __construct(ImageManipulationService $imageManipulationService, UriHelper $uriHelper)
    {
        $this->imageManipulationService = $imageManipulationService;
        $this->uriHelper                = $uriHelper;
    }


    /**
     * Shows the upload image page
     *
     * @return View
     */
    public function index(): View
    {
        return view('image.upload');
    }


    /**
     * @param Request $request
     * @param string  $path
     *
     * @return Response
     */
    public function serveImage(Request $request, string $path): Response
    {
        // Handle preset URLs
        $preset = $request->get('preset');

        if ($preset !== null) {
            return $this->imageManipulationService->getPresetImageResponse($path, $preset);
        }

        // Handle original images
        if ($request->getQueryString() === null) {
            return $this->imageManipulationService->getOriginalImageResponse($path);
        }

        // Handle custom image parameters
        return $this->imageManipulationService->getCustomImageResponse($path, $_GET);
    }


    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function uploadImageFromFile(Request $request): RedirectResponse
    {
        $pathPrefix = $request->input('path', '');
        $filePath   = $this->imageManipulationService->storeUploadedFile($request->file('image'), $pathPrefix);

        $imageUrl   = route('serveImage', ['path' => $filePath]);
        $cdnBaseUrl = $this->imageManipulationService->getCdnBaseUrl();

        // Swap the base URL for the CDN's base URL if it is configured
        if ($cdnBaseUrl !== null) {
            $imageUrl = $this->uriHelper->swapBaseUrl($imageUrl, $cdnBaseUrl);
        }

        return new RedirectResponse($imageUrl);
    }

}

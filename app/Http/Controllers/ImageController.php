<?php

namespace Nord\ImageManipulationService\Http\Controllers;

use Illuminate\Http\Request;
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
     * ImageController constructor.
     *
     * @param ImageManipulationService $imageManipulationService
     */
    public function __construct(ImageManipulationService $imageManipulationService)
    {
        $this->imageManipulationService = $imageManipulationService;
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
     * @return Response
     */
    public function uploadImage(Request $request): Response
    {
        $filePath = $this->imageManipulationService->storeUploadedFile($request->file('image'),
            $request->input('path'));

        return $this->imageManipulationService->getUploadedImageResponse($filePath);
    }

}

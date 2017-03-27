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
     * @param string $preset
     * @param string $path
     *
     * @return Response
     */
    public function servePresetImage(string $preset, string $path): Response
    {
        return $this->imageManipulationService->getPresetImageResponse($path, $preset);
    }


    /**
     * @param string $path
     *
     * @return Response
     */
    public function serveOriginalImage(string $path): Response
    {
        return $this->imageManipulationService->getOriginalImageResponse($path);
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

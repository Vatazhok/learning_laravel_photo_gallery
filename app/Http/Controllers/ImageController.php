<?php

namespace App\Http\Controllers;

use App\Http\Requests\Image\ImageAddWatermarkRequest;
use App\Http\Requests\Image\ImagePostRequest;
use App\Http\Requests\Image\ImageSharingImageRequest;
use App\Services\ImageService;
use App\Services\WatermarkService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;


class ImageController extends Controller
{
    protected $imageService;
    protected $watermarkService;

    public function __construct(
        ImageService $imageService,
        WatermarkService $watermarkService
    ) {
        $this->imageService = $imageService;
        $this->watermarkService = $watermarkService;
    }

    public function index(Request $request)
    {
        $images = $this->imageService->imagesUser($request->user()->id, $request);

        if ($images->total() === 0) {
            return Redirect::route('upload');
        }
        return Inertia::render('Gallery', [
            'images' => $images,
        ]);
    }

    public function upload()
    {
        return Inertia::render('UploadImage');
    }

    public function uploadImage(ImagePostRequest $request)
    {
        try {
            $this->imageService->imagesUpload($request->file('image'), $request->user()->id);
        } catch (ModelNotFoundException $exception) {
            return Redirect::back()->withErrors($exception->getMessage());
        }

        return Redirect::route('gallery')->with('message', __('imageSuccess.uploaded'));
    }

    public function sharingImage(ImageSharingImageRequest $request)
    {
        $requestCheckbox = $request;
        $resultImage = $this->imageService->imageSharing($requestCheckbox);
        return Inertia::render('SharingImage', [
            'images' => $resultImage
        ]);
    }

    public function showImageWithWatermark($id)
    {
        try {
            $images = $this->imageService->showImage($id);
            $watermarkImage = $this->watermarkService->showWatermarkImage($id);
        } catch (ModelNotFoundException $exception) {
            return Redirect::route('gallery')->withErrors($exception->getMessage());
        }

        return Inertia::render('ShowImageWithWatermark', [
            'images' => $images,
            'watermarkImage' => $watermarkImage
        ]);
    }

    public function addWatermark(ImageAddWatermarkRequest $request, $id)
    {
        $imageRadio = $request->radio;
        $images = $this->imageService->showImage($id);
        $this->watermarkService->addWatermarkToImage($images, $imageRadio);

        return Redirect::back()->with('message', __('imageSuccess.addWatermark'));
    }

    public function destroy($id)
    {
        $this->imageService->destroy($id);
        $this->watermarkService->destroy($id);

        return Redirect::route('gallery')->with('message', __('imageSuccess.deleteWatermarkWithImage'));
    }

    public function destroyWatermark($id)
    {
        $this->watermarkService->destroyOne($id);

        return Redirect::back()->with('message', __('imageSuccess.deleteImageWithWatermark'));
    }

    public function destroyAll(Request $request)
    {
        $this->imageService->destroyAll($request->checkbox);
        $this->watermarkService->destroyAll($request->checkbox);

        return Redirect::route('gallery')->with('message', __('imageSuccess.deleteWatermarkWithImage'));
    }


}

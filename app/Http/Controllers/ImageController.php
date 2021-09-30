<?php

namespace App\Http\Controllers;

use App\Http\Requests\Image\ImageAddWatermarkRequest;
use App\Http\Requests\Image\ImagePostRequest;
use App\Http\Requests\Image\ImageSharingImageRequest;
use App\Models\Image;
use App\Services\ImageService;
use App\Services\WatermarkService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function index()
    {
        $authId = auth::id();
        $images = $this->imageService->imagesUser($authId);
        return Inertia::render('Gallery', [
            'images' => $images,
        ]);
    }

    public function upload()
    {
        return Inertia::render('UploadImage');
    }

    public function post(ImagePostRequest $request)
    {
        $authId = Auth::id();
        $images = $request->files;
        $this->imageService->imageUpload($images, $authId);

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
        $images = $this->imageService->showImage($id);
        $watermarkImage = $this->watermarkService->showWatermarkImage($id);
        return Inertia::render('ShowImageWithWatermark', [
            'images' => $images,
            'watermarkImage' => $watermarkImage
        ]);
    }

    public function addWatermark(ImageAddWatermarkRequest $request, $id)
    {
        $imageRadio = $request->radio;
        $images = Image::where(config('constants.image.id'), $id)->first();
        $this->watermarkService->addWatermarkToImage($images, $imageRadio);

        return redirect()->back()->withSuccess(__('imageSuccess.addWatermark'));
    }

    public function destroy($id)
    {
        $this->imageService->destroy($id);
        $this->watermarkService->destroy($id);

        return redirect('/')->withSuccess(__('imageSuccess.deleteWatermarkWithImage'));
    }

    public function destroyWatermark($id)
    {
        $this->watermarkService->destroyOne($id);

        return redirect()->back()->withSuccess(__('imageSuccess.deleteImageWithWatermark'));
    }

    public function destroyAll(Request $request)
    {
        $this->imageService->destroyAll($request->checkbox);
        $this->watermarkService->destroyAll($request->checkbox);

        return redirect('/')->withSuccess(__('imageSuccess.deleteWatermarkWithImage'));
    }

}

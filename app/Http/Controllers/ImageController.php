<?php

namespace App\Http\Controllers;

use App\Http\Requests\Image\ImageAddWatermarkRequest;
use App\Http\Requests\Image\ImagePostRequest;
use App\Http\Requests\Image\ImageSharingImageRequest;
use App\Models\Image;
use App\Services\ImageService;
use App\Services\WatermarkService;
use Illuminate\Support\Facades\Auth;


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
        $authId = Auth::id();
        $images = $this->imageService->imagesUser($authId);
        return view('welcome')->with('images', $images[0]);
    }

    public function post(ImagePostRequest $request)
    {
        $authId = Auth::id();
        $images = $request->image;
        $this->imageService->imageUpload($images, $authId);
        return redirect('/')->withSuccess(__('imageSuccess.uploaded'));
    }

    public function sharingImage(ImageSharingImageRequest $request)
    {
        $requestCheckbox = $request;
        $resultImage = $this->imageService->imageSharing($requestCheckbox);
        return view('sharing_image')->with('images', $resultImage);
    }

    public function showImage($id)
    {
        $images = $this->imageService->showImage($id);
        $watermarkImage = $this->watermarkService->showWatermarkImage($id);
        return view(
            'show_image',
            [
                'images' => $images,
                'watermarkImage' => $watermarkImage
            ]
        );
    }

    public function addWatermark(ImageAddWatermarkRequest $request, $id)
    {
        $imageCheckbox = $request->checkbox;
        $images = Image::where(config('constants.image.id'), $id)->first();
        $this->watermarkService->addWatermarkToImage($images, $imageCheckbox);

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

}

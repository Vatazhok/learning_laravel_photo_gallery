<?php

namespace App\Http\Controllers;

use App\Http\Requests\Image\ImageAddWatermarkRequest;
use App\Http\Requests\Image\ImagePostRequest;
use App\Http\Requests\Image\ImageSharingImageRequest;
use App\Models\Image;
use App\Repository\ImageRepositoryInterface;

//use App\Repository\EloquentRepositoryInterface;
use App\Models\Watermark;

//use App\Repository\WatermarkRepositoryInterface;
use App\Services\WatermarkService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use App\Services\ImageService;


class ImageController extends Controller
{
    protected $imageService;
    protected $watermarkService;


    public function __construct(
        ImageService     $imageService,
        WatermarkService $watermarkService
    )
    {
        $this->imageService = $imageService;
        $this->watermarkService = $watermarkService;
    }


    public function index()
    {
        $authId = Auth::id();
        $images = $this->imageService->imagesUser($authId);
        return view('welcome')->with('images', $images);
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
        $image = Image::find($id);
        $image->delete();
        $watermarkImage = Watermark::where(config('constants.watermark.image_id'), $id)->get()->toArray();
        Watermark::where(config('constants.watermark.image_id'), $id)->delete();
        foreach ($watermarkImage as $watImg) {
            if (file_exists($watImg['image'])) {
                File::delete($watImg['image']);
            } else {
                return back()->withErrors(__('imageFailure.imageNotFound'));
            }
        }
        if (file_exists($image->image)) {
            File::delete($image->image);
        } else {
            return back()->withErrors(__('imageFailure.imageNotFound'));
        }
        return redirect('/')->withSuccess(__('imageSuccess.deleteWatermarkWithImage'));
    }

    public function destroyWatermark($id)
    {
        $image = Watermark::find($id);
        $image->delete();

        if (file_exists($image->image)) {
            File::delete($image->image);
        } else {
            return back()->withErrors(__('imageFailure.imageNotFound'));
        }

        return redirect()->back()->withSuccess(__('imageSuccess.deleteImageWithWatermark'));
    }

}

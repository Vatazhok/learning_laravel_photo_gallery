<?php

namespace App\Services;

use App\Models\Watermark;
use App\Repository\WatermarkRepositoryInterface;
use Illuminate\Support\Facades\File;


class WatermarkService
{

    protected $watermarkRepository;

    public function __construct(
        WatermarkRepositoryInterface $watermarkRepository,
    )
    {
        $this->watermarkRepository = $watermarkRepository;
    }

    public function showWatermarkImage($id)
    {
        return $this->watermarkRepository->show($id);
    }

    public function addWatermarkToImage($images, $imageCheckbox)
    {


        $pathImage = pathinfo($images->image)['filename'];
        $pathWatermark = pathinfo($imageCheckbox)['filename'];
        $img = \Intervention\Image\Facades\Image::make($images->image);
        /* insert watermark at bottom-right corner with 10px offset */
        $img->insert($imageCheckbox, 'bottom-right', 10, 10);

        $path = 'images/' . $pathImage . $pathWatermark . '.png';
        $img->save(public_path($path));
        $watermark = new Watermark();
        $watermark->user_id = $images->user_id;
        $watermark->image_id = $images->id;
        $watermark->image = $path;
        $watermark->save();
    }

    public function destroy($id)
    {
        $watermarkImage = $this->watermarkRepository->destroy($id);
        foreach ($watermarkImage as $watImg) {
            if (file_exists($watImg['image'])) {
                File::delete($watImg['image']);
            } else {
                return back()->withErrors(__('imageFailure.imageNotFound'));
            }
        }


    }

    public function destroyOne($id)
    {
        $image = $this->watermarkRepository->destroyOne($id);
        if (file_exists($image->image)) {
            File::delete($image->image);
        } else {
            return back()->withErrors(__('imageFailure.imageNotFound'));
        }

    }


}

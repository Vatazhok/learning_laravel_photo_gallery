<?php

namespace App\Services;


use App\Models\Image;
use App\Repository\ImageRepositoryInterface;
use Illuminate\Support\Facades\File;

class ImageService
{

    protected $imageRepository;

    public function __construct(
        ImageRepositoryInterface $imageRepository,
    ) {
        $this->imageRepository = $imageRepository;
    }

    public function imagesUser($authId)
    {
        $f=$this->imageRepository->whereUserIdPaginate($authId);
//        $r=[$f,response('statusCode',200)];
//        dd($r);
//        return [$f,response('statusCode',200)];
        return [$f,'statusCode'=>200];

    }

    public function imageUpload($images, $authId)
    {
        foreach ($images as $image) {
            $imageNewName = time() . $image->getClientOriginalName();
            $image->move('images', $imageNewName);
            $post = new Image;
            $post->user_id = $authId;
            $post->image = 'images/' . $imageNewName;
            $post->save();
        }
    }

    public function imageSharing($requestCheckbox)
    {
        foreach ($requestCheckbox->checkbox as $image) {
            $images[] = $this->imageRepository->whereImageId($image);
        }
        return call_user_func_array('array_merge', $images);
    }

    public function showImage($id)
    {
        return $this->imageRepository->showImage($id);
    }

    public function destroy($id)
    {
        $image = $this->imageRepository->destroy($id);
        if (file_exists($image->image)) {
            File::delete($image->image);
        } else {
            return back()->withErrors(__('imageFailure.imageNotFound'));
        }
    }

}



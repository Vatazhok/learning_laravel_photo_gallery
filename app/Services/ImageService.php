<?php

namespace App\Services;


use App\Models\Image;
use App\Repository\ImageRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class ImageService
{

    protected $imageRepository;
    protected string $orderBy = 'ASC';

    public function __construct(
        ImageRepositoryInterface $imageRepository,
    ) {
        $this->imageRepository = $imageRepository;
    }

    public function imagesUser($authId, $request)
    {
        if ($request->query('orderBy') === 'DESC') {
            $this->orderBy = 'DESC';
        }
        return $this->imageRepository->whereUserIdPaginate($authId, $this->orderBy);
    }

    public function imagesUpload(array $images, $authId)
    {
        foreach ($images as $image) {
            $this->imageUpload($image, $authId);
        }
    }

    public function imageUpload(UploadedFile $image, $authId)
    {
        $imageUpload = new Image();
        $imageUpload->user_id = $authId;
        $image->store(config('filesystems.disks.images.visibility'));
        $imageUpload->image = config('filesystems.disks.images.src') . '/' . $image->hashName();
        if (!$imageUpload->image) {
            throw new ModelNotFoundException('Image was not uploaded');
        }
        $imageUpload->save();
    }

    public function imageSharing($requestCheckbox)
    {
        foreach ($requestCheckbox->checkbox as $image) {
            $images[] = $this->imageRepository->whereImageId($image);
        }

        return array_merge(...$images);
    }

    public function sharingImgur($src)
    {
        $data = file_get_contents($src);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.imgur.com/3/image',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('image' => $data),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Client-ID '. env('IMGUR_KEY_ID')
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response)->data->link;
    }

    public function showImage($id)
    {
        $image = $this->imageRepository->showImage($id);
        if (!$image) {
            throw new ModelNotFoundException('Image with ID: ' . $id . ' not found');
        }

        return $image;
    }

    public function destroy($id)
    {
        $image = $this->imageRepository->destroy($id);
        if (file_exists($image->image)) {
            File::delete($image->image);
        } else {
            return back()->with('message', __('imageFailure.imageNotFound'));
        }
    }

    public function destroyAll($checkbox)
    {
        foreach ($checkbox as $id) {
            $image = $this->imageRepository->destroy($id);
            if (file_exists($image->image)) {
                File::delete($image->image);
            } else {
                return back()->with('message', __('imageFailure.imageNotFound'));
            }
        }
    }

}



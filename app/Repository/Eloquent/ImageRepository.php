<?php

namespace App\Repository\Eloquent;

use App\Models\Image;
use App\Repository\ImageRepositoryInterface;

class ImageRepository extends BaseRepository implements ImageRepositoryInterface
{

    /**
     * UserRepository constructor.
     *
     * @param Image $model
     */
    public function __construct(Image $model)
    {
        parent::__construct($model);
    }

    public function whereUserIdPaginate($authId, $orderBy)
    {
        return $this->model->where(config('constants.image.user_id'), $authId)->orderBy(
            'created_at',
            $orderBy
        )->paginate(12);
    }

    public function whereImageId($image)
    {
        return $this->model->where(config('constants.image.id'), $image)->get()->toArray();
    }

    public function showImage($id)
    {
        return $this->model->find($id);
    }

    public function destroy($id)
    {
        $image = $this->model->find($id);
        $image->delete();

        return $image;
    }

}

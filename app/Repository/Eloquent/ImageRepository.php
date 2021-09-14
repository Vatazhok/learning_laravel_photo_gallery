<?php

namespace App\Repository\Eloquent;

use App\Models\Image;
use App\Repository\ImageRepositoryInterface;
use Illuminate\Support\Collection;

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

    /**
     * @return Collection
     */


    public function whereUserIdPaginate($authId)
    {
        return $this->model->where(config('constants.image.user_id'), $authId)->paginate(12);
    }

    public function whereImageId($image)
    {
        return $this->model->where(config('constants.image.id'), $image)->get()->toArray();
    }


    public function showImage($id)
    {
        return $this->model->where(config('constants.image.id'), $id)->get();
    }

    public function destroy($id)
    {
        $image = $this->model->find($id);
        $image->delete();

        return $image;
    }

}

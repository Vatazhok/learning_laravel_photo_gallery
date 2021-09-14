<?php

namespace App\Repository\Eloquent;

use App\Http\Requests\Image\ImagePostRequest;
use App\Models\Image;
use App\Repository\ImageRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

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
    public function all(): Collection
    {
        return $this->model->all();
    }


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
    public function destroy($id){
        $image = $this->model->find($id);
        $image->delete();

        // перенести в сервіс
        if (file_exists($image->image)) {
            File::delete($image->image);
        } else {
            return back()->withErrors(__('imageFailure.imageNotFound'));
        }
    }

}

<?php

namespace App\Repository\Eloquent;


use App\Models\Watermark;
use App\Repository\WatermarkRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class WatermarkRepository extends BaseRepository implements WatermarkRepositoryInterface
{

    /**
     * UserRepository constructor.
     *
     * @param Watermark $model
     */
    public function __construct(Watermark $model)
    {
        parent::__construct($model);
    }

    /**
     * @return Collection
     */
    public function show($id)
    {
        return $this->model->where('image_id', $id)->get();
    }

    public function destroy($id)
    {
        $watermarkImage = Watermark::where(config('constants.watermark.image_id'), $id)->get()->toArray();
        Watermark::where(config('constants.watermark.image_id'), $id)->delete();
        // перенести в сервіс
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
        $image = Watermark::find($id);
        $image->delete();
        // перенести в сервіс
        if (file_exists($image->image)) {
            File::delete($image->image);
        } else {
            return back()->withErrors(__('imageFailure.imageNotFound'));
        }
    }
}

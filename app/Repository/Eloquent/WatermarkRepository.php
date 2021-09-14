<?php

namespace App\Repository\Eloquent;


use App\Models\Watermark;
use App\Repository\WatermarkRepositoryInterface;
use Illuminate\Support\Collection;

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
        return $watermarkImage;
    }

    public function destroyOne($id)
    {
        $image = Watermark::find($id);
        $image->delete();

        return $image;
    }
}

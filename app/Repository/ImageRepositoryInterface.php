<?php

namespace App\Repository;


use Illuminate\Support\Collection;

interface ImageRepositoryInterface
{
    public function all(): Collection;

    public function whereImageId($image);

    public function whereUserIdPaginate($authId);

    public function showImage($id);

}

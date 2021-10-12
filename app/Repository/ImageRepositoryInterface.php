<?php

namespace App\Repository;


interface ImageRepositoryInterface
{

    public function whereImageId($image);

    public function whereUserIdPaginate($authId, $orderBy);

    public function showImage($id);

    public function destroy($id);
}

<?php

namespace App\Repository;



interface WatermarkRepositoryInterface
{
    public function show($id);
    public function destroy($id);
    public function destroyOne($id);

}

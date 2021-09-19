<?php

namespace Tests\Feature\Services;

use App\Models\Image;
use App\Repository\Eloquent\ImageRepository;
use App\Services\ImageService;
use Tests\TestCase;
use This;


class ImageServiceTest extends TestCase
{


    /**
     * A basic feature test example.
     *
     * @return void
     */


    public function testImagesUser(): void
    {
        $imageModel = new Image();
        $imageInterface = new ImageRepository($imageModel);
        $imageService = new ImageService($imageInterface);
        $response = $imageService->imagesUser(1);

        $this->assertEquals(
            $response['statusCode'],
            200
        );
    }

}

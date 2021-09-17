<?php

namespace Tests\Unit;

use App\Models\Image;
use App\Models\User;
use Tests\TestCase;


class ProjectTest extends TestCase
{



//    public function testUploadImage()
//    {
////        $response = $this->post('/login', [
////            'login' => 'user@i.ua',
////            'password' =>'00000000'
////        ]);
//        $user = User::factory()->create();
//
//        $response = $this->actingAs($user)
//            ->withSession(['banned' => false])
//            ->get('/');
//
//        $images = Image::factory(Image::class)->create();
//        $imagePath = $images->image;
//        $this->post('/image', [
//            'image[]' => $images
//        ]);
//        if (file_exists($imagePath)) {
//            $response->status(200);
//        } else {
//            $response->status(404);
//        }
//
//        $response->assertOk();
//    }

}

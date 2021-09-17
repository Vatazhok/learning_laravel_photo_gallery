<?php

namespace Tests\Feature;

use App\Models\Image;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class Project extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUploadImage()
    {
//        Storage::fake('local');
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('/');

        $images = Image::factory(Image::class)->create();
        $imagePath = $images->image;
        $this->post('/image', [
            'image[]' => $images
        ]);
        if (file_exists($imagePath)) {
            $response = 0;
        } else $response = 1;
        // $imageDb= Image::where(config('constants.image.id'), 30)->get()->toArray();
        Storage::assertExists($imagePath);

        $response->assertOk();


    }

    public function test_example()
    {
//        $response = $this->post('/login', [
//            'login' => 'user@i.ua',
//            'password' =>'00000000'
//        ]);
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('/');
//redirect('/');

//        $response->dumpSession();
//        dd($response);
//$response = $this->post('/image/23');
        $response->assertStatus(200);
    }

    public function test_image()
    {
//        Storage::fake('local');
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->get('/');
        //$posts = Image::factory(Image::class)->create();
//        dd($posts->image);
        $file = UploadedFile::fake()->image('avatar.jpg');
//dd($file->hashName());
        $this->post('/image', [
            'image[]' => $file
        ]);

//        Storage::assertExists($file->hashName());
        Storage::assertExists('public/images/new-image.png');

    }

    public function testUserCanSuccessfullySubmitSingleImage(): void
    {

        $response = $this->post('/login', [
            'login' => 'user@i.ua',
            'password' => '00000000'
        ]);
        Storage::fake('uploads');

        $this->post('/image', [
            'image' => $image = UploadedFile::fake()->image('image1.jpg')
        ]);

        Storage::disk('uploads')->assertExists($image->hashName());
//        Storage::disk('uploads')->assertMissing('missing.jpg');
    }

    public function testDB()
    {

        $image = Image::where(config('constants.image.id'), 30)->get()->toArray();

    }
//    public function test_avatars_can_be_uploaded()
//    {
//        $response = $this->post('/login', [
//            'login' => 'user@i.ua',
//            'password' =>'00000000'
//        ]);
//
//
//
//
//        Storage::fake('public');
//
//
//        $this->post('/image',[
//            'image' => $file = UploadedFile::fake()->image('image.jpg', 1, 1)
//        ]);
//
//        $image = Image::where('name', 'image.jpg');
//
//        $imagePath = 'news/' . $file->hashName();
//
//        $this->assertEquals($imagePath, $image->image_path);
//
//        Storage::assertExists($imagePath);
//    }
}

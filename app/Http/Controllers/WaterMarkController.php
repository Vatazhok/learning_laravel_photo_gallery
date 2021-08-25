<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class WaterMarkController extends Controller
{
    public function imageWatermark()
    {
        $img = Image::make('http://localhost/learning_laravel_photo_gallery/public/images/image-test.png');

        /* insert watermark at bottom-right corner with 10px offset */
        $img->insert('http://localhost/learning_laravel_photo_gallery/public/images/watermark.png', 'bottom-right', 10, 10);

        $img->save(public_path('images/new-image.png'));

        $img->encode('png');
        $type = 'png';
        $new_image = 'data:image/' . $type . ';base64,' . base64_encode($img);

        return view('show_watermark', compact('new_image'));
    }
}

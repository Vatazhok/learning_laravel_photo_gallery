<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Watermark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;


class ImageController extends Controller
{
    public function index()
    {
        $images = Image::where(config('constants.image.user_id'), Auth::id())->paginate(12);
        return view('welcome')->with('images', $images);
    }

    public function post(Request $request)
    {
        $this->validate($request, [
            'image' => 'required'
        ]);
        $images = $request->image;
        foreach ($images as $image) {
            $image_new_name = time() . $image->getClientOriginalName();
            $image->move('images', $image_new_name);
            $post = new Image;
            $post->user_id = Auth::user()->id;
            $post->image = 'images/' . $image_new_name;
            $post->save();
        }
        Session::flash('success', 'Images uploaded');
        return redirect('/');
    }

    public function sharingImage(Request $request)
    {
        foreach ($request->checkbox as $image) {
            $images[] = Image::where(config('constants.image.id'), $image)->get()->toArray();
        }
        $resultImage = call_user_func_array('array_merge', $images);
        return view('sharing_image')->with('images', $resultImage);
    }

    public function showImage($id)
    {
        $images = Image::where(config('constants.image.id'), $id)->get();
        $watermarkImage = Watermark::where('image_id', $id)->get();
        return view(
            'show_image',
            [
                'images' => $images,
                'watermarkImage' => $watermarkImage
            ]
        );
    }

    public function addWatermark(Request $request, $id)
    {
        $image = $request->checkbox;
        $images = Image::where(config('constants.image.id'), $id)->first();

        $pathImage = pathinfo($images->image)['filename'];
        $pathWatermark = pathinfo($image)['filename'];
        $img = \Intervention\Image\Facades\Image::make($images->image);
        /* insert watermark at bottom-right corner with 10px offset */
        $img->insert($image, 'bottom-right', 10, 10);

        $path = 'images/' . $pathImage . $pathWatermark . '.png';
        $img->save(public_path($path));
        $watermark = new Watermark();
        $watermark->user_id = $images->user_id;
        $watermark->image_id = $images->id;
        $watermark->image = $path;
        $watermark->save();

        return redirect()->back();
    }

    public function destroy($id)
    {
        $image = Image::find($id);
        $image->delete();
        $watermarkImage = Watermark::where(config('constants.watermark.image_id'), $id)->get()->toArray();
        Watermark::where(config('constants.watermark.image_id'), $id)->delete();
        foreach ($watermarkImage as $watImg) {
            if (file_exists($watImg['image'])) {
                File::delete($watImg['image']);
            }
        }
        if (file_exists($image->image)) {
            File::delete($image->image);
        }
        Session::flash('success', 'Images deleted');
        return redirect('/');
    }

    public function destroyWatermark($id)
    {
        $image = Watermark::find($id);
        $image->delete();

        if (file_exists($image->image)) {
            File::delete($image->image);
        }

        Session::flash('success', 'Images deleted');
        return redirect()->back();
    }

}

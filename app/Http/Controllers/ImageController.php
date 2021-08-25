<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class ImageController extends Controller
{
    public function index()
    {
        $images = Image::where('user_id', Auth::id())->paginate(12);
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


//        $images=[];
        foreach ($request->checkbox as $image) {


            $images[] = Image::where('id', $image)->get()->toArray();

//            $resultImage[]=$images;
        }
            $resultImage=call_user_func_array('array_merge', $images);

        return view('sharing_image')->with('images', $resultImage);
    }

//    public function sharing(Request $request)
//    {
//        $images = Image::where('user_id', Auth::id())->paginate(12);
//        return view('welcome')->with('images', $images);
//    }

//    public function watermark(Request $request)
//    {
//        dd($request);
//        return view(
//            'pages.index',
//            [
//                'posts' => $posts,
//            ]
//        );
//    }

    public function destroy($id)
    {
        $image = Image::find($id);
        $image->delete();
        Session::flash('success', 'Images deleted');
        return redirect('/');
    }

}

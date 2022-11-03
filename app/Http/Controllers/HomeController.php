<?php

namespace App\Http\Controllers;

use App\Models\User;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::count();

        $widget = [
            'users' => $users,
            //...
        ];

        return view('home', compact('widget'));
    }

    public function uploadImage(Request $request)
    {
        if (isset($params['upload'])) {
            $url = Cloudinary::upload($request->file('upload')->getRealPath())->getSecurePath();

            return response()->json(['fileName' => $request->file('upload')->getClientOriginalName(), 'uploaded'=> 1, 'url' => $url]);
        }

        return null;
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FirebaseUser;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = FirebaseUser::count();

        $widget = [
            'users' => $users,
        ];

        return view('home', compact('widget'));
    }

    public function uploadImage(Request $request)
    {
        $params = $request->all();
        try {
            if (isset($params['upload'])) {
                $url = Cloudinary::upload($request->file('upload')->getRealPath())->getSecurePath();

                return response()->json(['fileName' => $request->file('upload')->getClientOriginalName(), 'uploaded' => 1, 'url' => $url]);
            }

            if (isset($params['uploads'])) {
                $uploads = [];
                foreach ($params['uploads'] as $upload) {
                    $url = Cloudinary::upload($upload->getRealPath())->getSecurePath();
                    $uploads[] = [
                        'fileName' => $upload->getClientOriginalName(),
                        'uploaded' => 1,
                        'url' => $url
                    ];
                }

                return response()->json($uploads);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }

        return response()->json(['fileName' => '', 'uploaded' => 1, 'url' => '']);
    }
}

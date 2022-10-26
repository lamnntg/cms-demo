<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Club;
use App\Models\Event;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Redirect;

class EventController extends Controller
{
    public function index(Request $request) {
        $events = Event::all();
        $clubs = Club::all();

        return view('event', compact('events', 'clubs'));
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request) {
        $params = $request->all();
        if (isset($params['thumnail'])) {
            $url = Cloudinary::upload($request->file('thumnail')->getRealPath())->getSecurePath();
        }

        try {
            Event::create([
                'name' => $params['name'],
                'club_id' => $params['clubId'],
                'description' => $params['description'],
                'time_start' => $params['time_start'],
                'time_end' => $params['time_end'],
                'thumnail' => $url ?? null,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('event')->with('');
        }

        return redirect()->route('event')->with('');
    }
}

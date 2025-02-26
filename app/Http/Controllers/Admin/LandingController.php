<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingPageConfig;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LandingController extends Controller
{
    public function index()
    {
        $landingConfigs = LandingPageConfig::where('type', 'banner')->get();
        $texts = LandingPageConfig::where('type', 'text')->get();

        $title = '';
        $description = '';
        foreach ($texts as $text) {
            if ($text->key == 'text_title') {
                $title = $text;
            }
            if ($text->key == 'text_description') {
                $description = $text;
            }
        }

        return view('landing', compact('landingConfigs', 'title', 'description'));
    }

    public function changeText(Request $request)
    {

        DB::beginTransaction();

        try {
            $params = $request->all();

            if (!isset($params['text_title']) || !isset($params['text_description'])) {
                return redirect()->back();
            }
            LandingPageConfig::where('key', 'text_title')->first()->update([
                'value' => $params['text_title'],
            ]);

            LandingPageConfig::where('key', 'text_description')->first()->update([
                'value' => $params['text_description'],
            ]);

            DB::commit();
            // all good

        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
        }

        return redirect()->route('landing');
    }


    public function changeBanner(Request $request)
    {
        DB::beginTransaction();

        try {
            $params = $request->all();

            if (!isset($params['file'])) {
                return redirect()->back();
            }
            // $imagePath = $request->file('file')->store('images', 'public');
            $params['url'] = Cloudinary::upload($params['file']->getRealPath())->getSecurePath();
            // $params['url'] = asset('storage/' . $imagePath);
            switch ($params['banner'] ?? null) {
                case 1:
                    $updateValues['key'] = 'banner_1';

                    break;
                case 2:
                    $updateValues['key'] = 'banner_2';

                    break;
                default:
                    $updateValues['key'] = 'banner_3';

                    break;
            }
            $updateValues['value'] = $params['url'];
            LandingPageConfig::where('key', $updateValues['key'])->first()->update([
                'value' => $updateValues['value'],
            ]);

            DB::commit();
            // all good

        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
        }

        return redirect()->route('landing');
    }
}

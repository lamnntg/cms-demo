<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingPageConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LandingController extends Controller
{
    public function index()
    {
        $landingConfigs = LandingPageConfig::all();

        return view('landing', compact('landingConfigs'));
    }

    public function changeBanner(Request $request)
    {

        DB::beginTransaction();

        try {
            $params = $request->all();

            if (!isset($params['file'])) {
                return redirect()->back();
            }

            

            switch ($params['banner'] ?? null) {
                case 1:
                    $updateValues['key'] = 'banner_1';
                    $updateValues['value'] = $params['url'];

                    break;
                case 2:
                    $updateValues['key'] = 'banner_2';
                    $updateValues['value'] = $params['url'];

                    break;
                default:
                    $updateValues['key'] = 'banner_3';
                    $updateValues['value'] = $params['url'];

                    break;
            }
            LandingPageConfig::where('value', $updateValues['key'])->first()->update([
                'value' => $updateValues['value'],
            ]);

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
        }
    }
}

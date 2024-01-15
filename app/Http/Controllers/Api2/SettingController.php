<?php

namespace App\Http\Controllers\Api2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Http\Resources\SettingResource;
use App\Helpers\ApiResponse;
class SettingController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        
        $setting = Setting::find(1);
        if($setting) return ApiResponse::sendResponse(200 , 'successfully' ,new SettingResource($setting) );
        return  ApiResponse::sendResponse(200 , 'Failed' ,[]);
    }
}

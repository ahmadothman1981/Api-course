<?php

namespace App\Http\Controllers\Api2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Http\Resources\CityResource;
use App\Helpers\ApiResponse;
class CityController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $cities = City::all();
        if($cities)
        {
            return ApiResponse::sendResponse(200,'cities loaded successfully',CityResource::collection($cities));
        }
        return ApiResponse::sendResponse(200,'No Data Available',[]);
    }
}

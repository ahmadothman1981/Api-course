<?php

namespace App\Http\Controllers\Api2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\District;
use App\Http\Resources\DistrictResource;
use App\Helpers\ApiResponse;
class DistrictController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request,$city_id)
    {
        $districts = District::where('city_id',$city_id)->get();
        if($districts)
        {
            return ApiResponse::sendResponse(200,'District and its Cities',DistrictResource::collection($districts));
        }
        return ApiResponse::sendResponse(200,'No Data Available',[]);
    }
}

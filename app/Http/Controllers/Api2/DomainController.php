<?php

namespace App\Http\Controllers\Api2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Domain;
use App\Http\Resources\DomainResource;
use App\Helpers\ApiResponse;

class DomainController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $domain = Domain::all();
        if($domain)
        {
            return ApiResponse::sendResponse(200,'Domains Retrive Successfully',DomainResource::collection($domain));
        }
        return ApiResponse::sendResponse(200,'Domains Are Empty',[]);
    }
}

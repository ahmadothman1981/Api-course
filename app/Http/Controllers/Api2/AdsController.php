<?php

namespace App\Http\Controllers\Api2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ad;
use App\Helpers\ApiResponse;
use App\Http\Resources\AdResource;
use App\Http\Requests\AdRequestUser;

class AdsController extends Controller
{
    public function index()
    {
        $ads = Ad::latest()->paginate(10);

        if(count($ads) >0)
        {
            if($ads->total() > $ads->perPage())
            {
                $data=[
                    'records'=>AdResource::collection($ads),
                    'paginate_links'=>[
                        'current page'=>$ads->currentPage(),
                        'per page'=>$ads->perPage(),
                        'total'=>$ads->total(),
                        'links'=>[
                            'first'=>$ads->url(1),
                            'last'=>$ads->url($ads->lastPage()),
                        ],
                    ],
                ];
            }else{
                return AdResource::collection($ads);
            }
            return ApiResponse::sendResponse(200,'Ads REtrived Successfully',$data);
        }
        return ApiResponse::sendResponse(200,'No Ads Are Available',[]);
    }

    public function latest()
    {
        //dd('hi');
        $ads = Ad::latest()->take(2)->get();
        
        if(count($ads)>0)
        {
            return ApiResponse::sendResponse(200,'Latest Ads ',$ads);
        }
         return ApiResponse::sendResponse(200,' NoLatest Ads ',[]);   
        
    }

    public function domain($domain_id)
    {
        $domain = Ad::where('domain_id',$domain_id)->latest()->get();

        if(count($domain)>0)
        {
            return ApiResponse::sendResponse(200,'domain retirived successfully',AdResource::collection($domain));
        }
        return ApiResponse::sendResponse(200,'No Data',[]);
    }

    public function search(Request $request)
    {
        $search_word = $request->has('search') ? $request->input('search') : null;

        $ads = Ad::when($search_word != null, function ($word) use ($search_word){
            $word->where('title','like','%'.$search_word.'%');
        })->latest()->get();

        if(count($ads)>0)
        {
            return ApiResponse::sendResponse(200,'search completed',AdResource::collection($ads));
        }
        return ApiResponse::sendResponse(200,'no search available',[]);
    }

    public function create(AdRequestUser $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        $new_ad = Ad::create($data);
        if($new_ad) return ApiResponse::sendResponse(201,'ads created successfully',new AdResource($new_ad));
    }

    public function update(AdRequestUser $request ,$Ad_id)
    {
        $ad = Ad::findOrFail($Ad_id);
        if($ad->user_id != $request->user()->id)
        {
            return ApiResponse::sendResponse(403,'you are not allowed',[]);
        }
        $data = $request->validated();

        $update_ad = $ad->update($data);
        if($update_ad) return ApiResponse::sendResponse(201,'ads updated successfully',new AdResource($ad));

    }

    public function delete(Request $request,$ad_id)
    {
        $ad = Ad::findOrFail($ad_id);
        if($ad->user_id != $request->user()->id)
        {
            return ApiResponse::sendResponse(403,'you are not allowed',[]);
        }

        $delete_ad = $ad->delete();
        if($delete_ad) return ApiResponse::sendResponse(200,'ads deleted successfully',[]);
    }

    public function myAds(Request $request)
    {
        $ads =Ad::where('user_id',$request->user()->id)->latest()->get();
        if(count($ads)>0)
        {
            return ApiResponse::sendResponse(200,'myads retrived successfully', AdResource::collection($ads));
        }
        return ApiResponse::sendResponse(200,'there no ads with your user name',[]);
    }
}

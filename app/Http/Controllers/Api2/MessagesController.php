<?php

namespace App\Http\Controllers\Api2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\NewMessageRequest;
use App\Models\Message;
use App\Helpers\ApiResponse;
class MessagesController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(NewMessageRequest $request)
    {
        $data = $request->validated();
        $record = Message::create($data);

        if($record)
        {
            return ApiResponse::sendResponse(201,'message created successfully',[]);
        }
    }
}

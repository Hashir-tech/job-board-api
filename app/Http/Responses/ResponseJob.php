<?php

namespace App\Http\Responses;

use App\Http\Responses\BaseResponse;
use Illuminate\Support\Collection;


class ResponseJob extends BaseResponse {


    public function prepareJobsResponse($jobs)
    {   
        if(!empty($jobs)){
            $response = [
                          'pagination' => [
                            'next_cursor' => $jobs->nextCursor()?->encode(),  // Encoded cursor for next page
                            'prev_cursor' => $jobs->previousCursor()?->encode(), // Encoded cursor for previous page
                           ],
                           'jobs' => $jobs->items()
                        ];

            $response_message = $this->getMessageData('success', 'en')['general_success'];
            
            return $this->successResponse($response_message, $response);
        }
        $response_message = $this->getMessageData('error', 'en')['general_error'];
        return $this->errorResponse($response_message);
    }

}
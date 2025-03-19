<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\JobService;

class JobController extends Controller
{
    public function index(Request $request)
    { 
        try{
            return (new JobService())->getJobs($request);
        }  
        catch(\Exception $e){
            $this->storeException($e);
            return $this->errorResponse($this->getMessageData('error', 'en')['general_error'],500);
        }


    }

}

<?php


namespace App\Http\Traits;

use Illuminate\Support\Facades\Request;
use App\Models\CodeException;
use Illuminate\Support\Facades\Response;
use GuzzleHttp\Client;


trait CommonService {


    /**
     * errorResponse method
     * @param type $error
     * @param type $code
     * @return Response
     */
    public function errorResponse($error, $code = 2044) {
        $response = [];
        $response['success'] = false;
        $response['message'] = $error;
        $response['status_code'] = $code;
        return Response::json($response);
    }

    public function errorResponseWithData($error, $data=[], $code = 2044) {
        $response = [];
        $response['success'] = false;
        $response['data'] = $data;
        $response['message'] = $error;
        $response['status_code'] = $code;
        return Response::json($response);
    }

    /**
     * SuccessResponse method
     * @param type $msg
     * @param type $data
     * @param type $code
     * @return type
     */
    public function successResponse($msg, $data = [], $code = 200) {
        $response = [];
        $response['success'] = true;
        $response['data'] = $data;
        $response['message'] = $msg;
        $response['status_code'] = $code;
        return Response::json($response);
    }

    /**
     * SuccessResponseWithoutData method
     * @param type $msg
     * @return type
     */
    public function successResponseWithoutData($msg, $code = 200) {
        $response = [];
        $response['success'] = true;
        $response['message'] = $msg;
        $response['status_code'] = $code;
        return Response::json($response);
    }

    public function storeException($ex)
    {

        $exceptions = new CodeException();
        $exception['exception_file'] = $ex->getFile();
        $exception['exception_line'] = $ex->getLine();
        $exception['exception_message'] = $ex->getMessage();
        $exception['exception_url'] = \Request::url();
        $exception['exception_code'] = $ex->getCode();
        $exception['user_id'] = !empty(\auth()->user()->id) ? \auth()->user()->id : 0;
        $exceptions->create($exception);
    }

}

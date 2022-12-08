<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function insert()
    {
        $data_array=$this->read_data();

    }

    private function read_data()
    {
        $open = fopen('user_data.txt', 'r');
        $array = [];
        while (!feof($open) && strlen(fgets($open))>0) {
            $getTextLine = fgets($open);
            $getTextLine = substr($getTextLine, 0, -2);
            Log::debug($getTextLine."8888888888888888888888888888888888888888888888888888888888888888888");
            list($mobile, $nationalCode) = explode("\t", $getTextLine);
            $result[ 'mobile' ] = $mobile;
            $result[ 'nationalCode' ] = $nationalCode;
//            dd($result);
            array_push($array, $result);

        }
        fclose($open);
        return $array;
    }

}

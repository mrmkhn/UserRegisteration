<?php

namespace Modules\User\Http\Controllers;

use Modules\User\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Modules\User\Repositories\UserRepository;


class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository=$userRepository;

    }
    public function insert()
    {
        $data_array=$this->read_data();
        foreach($data_array as $row){
            $validator=$this->validator($row);
            if ($validator->fails())
                Storage::disk('local')->append('invalidate_data.txt',implode("\t",$row));
            else
                $this->userRepository->create($row);

        }
        return response(true);

    }

    private function read_data()
    {
        $file =Storage::get('user_data.txt');
        $row_array=preg_split('/\n/',$file);
        $result=[];
        foreach ($row_array as $row)
        {
            if(strlen($row))
            {
                list($mobile, $nationalCode)=explode("\t", $row);
                $array[ 'mobile' ] = $mobile;
                $array[ 'nationalCode' ] = $nationalCode;
                array_push($result, $array);
            }

        }
        return $result;
    }

    private function validator($row)
    {
        return  Validator::make($row, [
            'mobile' => 'required|unique:users,mobile',
            'nationalCode' => 'required|unique:users,nationalCode',
        ]);
    }

}

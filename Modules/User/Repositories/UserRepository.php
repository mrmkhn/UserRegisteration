<?php


namespace Modules\User\Repositories;
use Modules\User\Models\User;

class UserRepository
{


    public function create($row)
    {
         User::create([
            'mobile'=>$row['mobile'],
            'nationalCode'=>$row['nationalCode'],
        ]);
    }
}

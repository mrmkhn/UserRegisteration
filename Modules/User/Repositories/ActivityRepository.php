<?php


namespace Modules\User\Repositories;


use Illuminate\Support\Str;
use Modules\ACL\Repositories\RoleRepository;
use Modules\Notification\Repositories\NotificationRepository;
use Modules\User\Models\Activity;
use Modules\User\Models\User;

class ActivityRepository
{
    public function find($id)
    {
        return Activity::find($id);
    }

    public function all()
    {
        return Activity::orderby('title', 'asc')->get();
    }

    public function get_by_user($user)
    {
        $array=  is_null($user->activity_id)?[]:explode(',',$user->activity_id);
        return Activity::whereIn('id',$array)->withTrashed()->get();
    }

    public function create( $array)
    {
        return Activity::create($array);

    }

    public function update($activity,  $array)
    {
        return $activity->update($array);
    }

    public function delete($activity)
    {
        return $activity->delete();

    }
}

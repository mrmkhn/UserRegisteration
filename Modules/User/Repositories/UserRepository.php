<?php


namespace Modules\User\Repositories;


use App\helpers\convertToEnglish;
use Hekmatinasser\Verta\Verta;
use Illuminate\Support\Str;
use Modules\ACL\Repositories\RoleRepository;
use Modules\Notification\Repositories\NotificationRepository;
use Modules\Plugin\Repositories\PluginRepository;
use Modules\User\Models\User;

class UserRepository
{
    private $roleRepository;
    private $notificationRepository;
    private $pluginRepository;
    public function __construct(RoleRepository $roleRepository, NotificationRepository $notificationRepository,PluginRepository $pluginRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->notificationRepository = $notificationRepository;
        $this->pluginRepository = $pluginRepository;

    }

    public function find_with_mobile($mobile)
    {
        return User::where('mobile', $mobile)->first();
    }

    public function create(array $array)
    {
//        $user=User::create(array_merge($array,['referral_code'=>STR::random(10)])) ;
        $user = User::create($array);

        $this->notificationRepository->attach_all_to_user($user);
        $this->pluginRepository->attach_all_to_user($user);

        return $user;

    }

    public function course_suggestions($user): array
    {
        return $user->course_suggestions->pluck('id')->toArray();
    }

    public function find($user_id)
    {
        return User::find($user_id);

    }

    public function find_with_trash($user_id)
    {
        return User::withTrashed()->find($user_id);

    }

    public function course_suggestions_with_term($user, $term)
    {
        return $user->course_suggestions()->where('term_id', $term->id)->get();
    }

    public function get_all_teachers()
    {
        $role = $this->roleRepository->get_with_slug('Teacher');
        return $role->users()->orderby('created_at', 'desc')->get();
    }
    public function get_all_admins()
    {
        $role = $this->roleRepository->get_with_slug('Admin');
        return $role->users()->orderby('created_at', 'desc')->get();
    }
    public function get_array_all_courses($user_id)
    {
        $user = User::find($user_id);
        $courses = $user->courses()->where('access', 1)->get();
        return $courses->pluck('id')->unique()->toArray();

    }

    public function get_termic_courses($user)
    {
        return $user->courses()->where('term_id', '!=', null)->where('skill_id', null)->get();
//        return $user->courses()->where('access',1)->where('term_id','!=',null)->where('skill_id',null)->get();


    }

    public function get_shop_courses($user)
    {
        return $user->courses()->where('access', 1)->where('term_id', null)->where('skill_id', null)->get();

    }

    public function get_skills($user)
    {
        return $user->courses()->where('term_id', null)->where('skill_id', '!=', null)->pluck('skill_id')->unique()->toArray();

    }

    public function attach_role($user, $role)
    {
        return $user->roles()->attach($role);

    }

    public function hasRoleExcept($user, $role)
    {
        return !!$user->roles->whereNotIn('slug', $role)->first();

    }

    public function find_with_username($username)
    {
        return User::where('username', $username)->first();

    }

    public function all_with_paginate($search,$city,$activity,$from,$to,$per_page)
    {
        $from_g=$from?Verta::parse( ConvertToEnglish::convertString($from))->formatGregorian('Y-m-d H:i:s'):null;
        $to_g=$to?Verta::parse(ConvertToEnglish::convertString($to))->formatGregorian('Y-m-d H:i:s'):null;
        return User::when($search, function ($q) use ($search) {
            $q->where( function ($qu)use($search){
                $qu->where('firstName', 'like', '%' . $search . '%')->orwhere('lastName', 'like', '%' . $search . '%')->orwhere('mobile', 'like', '%' . $search . '%')->orwhere('email', 'like', '%' . $search . '%');
            });
        })->when($city, function ($q) use ($city) {
            $q->where('city_id', $city);
        })->when($activity, function ($q) use ($activity) {
            $q->where(  function ($query)use($activity){
                $query->where('activity_id',  'like',  $activity."," . '%')->orwhere('activity_id',  'like',  $activity)->orwhere('activity_id',  'like',  '%'.",".$activity)->orwhere('activity_id',  'like', '%'. ",".$activity."," . '%');
            });
        })->when($from, function ($q) use ($from_g) {
            $q->where('created_at','>=', $from_g);
        })->when($to, function ($q) use ($to_g) {
            $q->where('created_at','<=', $to_g);
    })->orderby('created_at','desc')->paginate($per_page??20);

    }

    public function get_roles($user_id)
    {
        $user = $this->find($user_id);
        return $user->roles;
    }

    public function update($user, $array)
    {
        return $user->update($array);
    }

    public function get_special_teachers()
    {
        $role = $this->roleRepository->get_with_slug('Teacher');
        return $role->users()->where('special_teachers', 1)->get();
    }

    public function delete($user)
    {
        return $user->delete();
    }

    public function hasRole($user, $roles)
    {
        if (is_string($roles)) {
            return $user->roles->contains('slug', $roles);
        }

        return !!$roles->intersect($user->roles)->count();
    }

    public function get_with_id_array($array)
    {

        $users= User::whereIn('id',$array)->get();

        return $users = $users->sortby(function($model) use ($array){
            return array_search($model->id, $array);
        });
    }

    public function get_all_users()
    {
        $role = $this->roleRepository->get_with_slug('Student');
        return $role->users()->orderby('created_at', 'desc')->get();
    }

    public function get_all_students()
    {
        return User::whereHas('roles', function ($q) {
            $q->where('slug', 'Student');
//        })
//            ->whereHas('courses',function($q) {
//            $q->where('courses.id','>',0);
        })->get();
    }

    public function get_favorite_article($user)
    {
        return $user->favorite_article;
    }

    public function get_notification($user, $notification_slug)
    {
        return $user->notif()->where('slug', $notification_slug)->where('status', 'active')->first();
    }

    public function get_all_notification($user)
    {
        return $user->notif()->where('status', 'active')->get();
    }

    public function find_with_referral_code($referral_code)
    {
        return User::where('referral_code', $referral_code)->withTrashed()->first();

    }

    public function get_courses_with_order($user, $order)
    {

        return $user->courses()->where('order_id', $order->id)->get();

    }

    public function updatePivot($user, $course, $array)
    {
        return $user->courses()->updateExistingPivot($course, $array);
    }

    public function all_users()
    {
        return User::all();
    }

    public function all_active_users()
    {
        return User::active()->get();
    }

    public function get_courses($user)
    {
        return $user->courses()->where('access', 1)->get() ?? collect([]);
    }

    public function get_courses_with_teacher($user, $type = null)
    {
        return $user->taught_courses()->when($type, function ($query) use ($type) {
            $query->where('show_in_' . $type, 1);
        })->active()->get();
    }

    public function find_with_ticket_token($token)
    {
        return User::where('ticket_token', $token)->first();

    }

    public function all_inactive()
    {
        return User::onlyTrashed()->get();

    }

    public function restore($user)
    {
        return $user->restore();
    }

    public function all_iran_1450($search = null)
    {
        return User::where('iran1450', 1)->when($search, function ($q) use ($search) {
            $q->where(function ($qu) use ($search) {
                $qu->where('firstName', 'like', '%' . $search . '%')->orwhere('lastName', 'like', '%' . $search . '%')
                ->orwherehas('city', function ($query) use ($search) {
                    $query->where('title', 'like', '%' . $search . '%');
                });
            });
        })->orderby('created_at','desc')->get();
    }

}

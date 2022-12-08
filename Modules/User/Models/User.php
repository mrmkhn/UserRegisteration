<?php

namespace Modules\User\Models;

use App\Traits\global_scopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Course\Traits\CourseBelongsToRelations;
use Modules\User\Traits\UserFunctions;
use Modules\User\Traits\UserHasManyRelations;
use Modules\User\Traits\UserManyToManyRelations;
use Modules\User\Traits\UserRelations;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use UserRelations;
    use global_scopes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstName',
        'lastName',
        'username',
        'image_id',
        'nationalCode',
        'mobile',
        'accept_rules',
        'email',
        'bornDate',
        'nickname',
        'password',
        'referral_code',
        'api_token',
        'status',
        'special_teachers',
        'create_user',
        'update_user',
        'delete_user',
        'prefix',
        'english_name',
        'phone',
        'address',
        'degree_of_education',
        'company_name',
        'company_logo',
        'activity_id',
        'iran1450',
        'iran1450_options',
        'iran1450_register_date',
        'city_id',
        'company_description',
        'secret_description',
        'teachers_executive_records',
        'teachers_scientific_records',
        'teacher_teaser',
        'teacher_banner',
        'updated'

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    static $enumStatuses = [
        'active',
        'deactivate',
    ];


//    public function hasRole($user, $roles)
//    {
//        if(is_string($roles)) {
//            return $user->roles->contains('slug' , $roles);
//        }
//
//        return !! $roles->intersect($user->roles)->count();
//    }
    public function hasRole( $roles)
    {
        if(is_string($roles)) {
            return $this->roles->contains('slug' , $roles);
        }

        return !! $roles->intersect($this->roles)->count();
    }
}

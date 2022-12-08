<?php

namespace Modules\User\Models;

use App\Traits\global_scopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\User\Traits\ActivityRelations;

class Activity extends Model
{
    use SoftDeletes;
    use ActivityRelations;
    use global_scopes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'status',


    ];

    static $enumStatuses = [
        'active',
        'deactivate',
    ];
}

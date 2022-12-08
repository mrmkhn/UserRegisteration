<?php


namespace Modules\User\Traits;


use Modules\ACL\Models\Role;
use Modules\Article\Models\Article;
use Modules\ArticleGroup\Models\ArticleGroup;
use Modules\Certificate\Models\Certificate;
use Modules\Comment\Models\Comment;
use Modules\Consultation\Models\Consultation;
use Modules\Course\Models\Course;
use Modules\CustomerClub\Score\Models\ScoreTransaction;
use Modules\Exam\Models\Exam;
use Modules\Media\Models\Media;
use Modules\Notification\Models\Notification;
use Modules\Plugin\Models\Plugin;
use Modules\Plugin\Repositories\PluginRepository;
use Modules\StateCityRegion\City\Models\City;
use Modules\Task\Models\Task;

trait UserRelations
{
    public function image()
    {
        return $this->belongsTo(Media::class,'image_id');
    }
    public function banner()
    {
        return $this->belongsTo(Media::class,'teacher_banner');
    }
    public function teaser()
    {
        return $this->belongsTo(Media::class,'teacher_teaser');
    }
    public function logo()
    {
        return $this->belongsTo(Media::class,'company_logo');
    }
    public function consultation()
    {
        return $this->hasOne(Consultation::class);

    }
    public function course_suggestions()
    {
        return $this->belongsToMany(Course::class,'course_suggestion','user_id','course_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_student', 'student_id', 'course_id')->withpivot('term_id','skill_id','access');

    }
    public function roles()
    {
        return $this->belongsToMany(Role::class,'role_user','user_id','role_id');
    }
    public function taught_courses()
    {
        return $this->belongsToMany(Course::class, 'course_teacher', 'teacher_id', 'course_id');

    }
    public function favorite_article()
    {
        return $this->belongsToMany(ArticleGroup::class, 'favorite_articles', 'user_id', 'article_group_id');
    }
    public function notif()
    {
        return $this->belongsToMany(Notification::class, 'notification_user', 'user_id', 'notification_id')->withPivot('send_sms','send_email','send_alert');

    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function tasks()
    {
        return $this->hasMany(Task::class, 'teacher_id');
    }
    public function exams()
    {
        return $this->hasMany(Exam::class, 'teacher_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class,'city_id')->withTrashed();
    }
    public function plugins()
    {
        return $this->hasMany(Plugin::class, 'create_user');
    }
    public function score_transaction()
    {
        return $this->hasMany(ScoreTransaction::class, 'user_id') ->groupBy('user_id')
            ->orderByRaw('SUM(bonus) DESC');
    }
    public function articles()
    {
        return $this->hasMany(Article::class, 'create_user');
    }
    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'student_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{

	protected $appends = [
        'approved',
        'lessons',
    ];

    /**
     * Attributes that should be mass-assignable.
     * Additional to those of the parent class.
     *
     * @var array
     */
    protected $fillable = [ 'user_id', 'course_id' ];

    /*
     * ---------------
     * Methods
     * ---------------
    */

    public function getApprovedAttribute()
    {
    	$lessonsCompleted = \DB::table('enrollment_lessons')->where('enrollment_id', $this->id)->count();
    	$lessonsCount = $this->course->lessons()->count();

        return $lessonsCompleted >= $lessonsCount;
    }

    public function getLessonsAttribute()
    {
    	$lessonsCompleted = \DB::table('enrollment_lessons')->where('enrollment_id', $this->id)->get();
    	$lessons = \DB::table('lessons')->where('course_id', $this->course->id)->get();
    	//$course = $this->course;

        $listLessons = $lessons->each(function ($lesson) use ($lessonsCompleted) {
        	$lesson->approved = $lessonsCompleted->where('lesson_id',$lesson->id)->count() ? true : false;
        });

        return $listLessons;
    }

    /*
     * ---------------
     * Relationships
     * ---------------
    */

    public function course()
    {
        return $this->belongsTo('App\Course');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model
{
    use SoftDeletes;

    /**
     * Attributes that should be mass-assignable.
     * Additional to those of the parent class.
     *
     * @var array
     */
    protected $fillable = [ 'title', 'description', 'course_id' ];

    /**
     * Attributes that should be appended to the entity
     *
     * @var array
     */
    protected $appends = [

    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        
    ];

    /*
     * ---------------
     * Methods
     * ---------------
    */

    /*
     * ---------------
     * Relationships
     * ---------------
    */

    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    public function questions()
    {
        return $this->hasMany('App\Item')->where('type', 'question');
    }
}

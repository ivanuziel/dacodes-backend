<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
	use SoftDeletes;

    /**
     * Attributes that should be mass-assignable.
     * Additional to those of the parent class.
     *
     * @var array
     */
    protected $fillable = [ 'title', 'description' ];

    /**
     * Attributes that should be appended to the entity
     *
     * @var array
     */
    protected $appends = [  ];

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

    public function lessons()
    {
        return $this->hasMany('App\Lesson');
    }
    
}

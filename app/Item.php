<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * Attributes that should be mass-assignable.
     * Additional to those of the parent class.
     *
     * @var array
     */
    protected $fillable = [ 'lesson_id', 'type', 'title', 'description', 'order', 'data', 'value' ];

    /**
     * Attributes that should be appended to the entity
     *
     * @var array
     */
    protected $appends = [  ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'object'
    ];

    public function setDataAttribute($value) {
        $this->attributes['data'] = json_encode(json_decode(trim($value)));
    }

    /*
     * ---------------
     * Relationships
     * ---------------
    */

    public function lesson()
    {
        return $this->belongsTo('App\Lesson');
    }

    /*
     * ---------------
     * Scopes
     * ---------------
    */

    public function scopeQuestion($query)
    {
        return $query->where('type', 'question');
    }
}

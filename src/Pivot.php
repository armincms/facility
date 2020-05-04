<?php

namespace Armincms\Facility;

use Illuminate\Database\Eloquent\Relations\MorphPivot as Model;
 

class Pivot extends Model
{ 
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function setValueAttribute($value)
    {
        $this->attributes['value'] = is_array($value) : json_encode($value) : $value;
    }
}

<?php

namespace Armincms\Facility; 

use Armincms\Models\Translation as  Model;   

class Translation extends Model  
{     
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'options' => 'json',
    ]; 
}
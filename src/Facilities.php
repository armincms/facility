<?php

namespace Armincms\Facility;
  

trait Facilities 
{ 
    public function facilities()
    {
        return $this->morphToMany(Facility::class, 'facilitate', 'facility_facilitate')
        			->withPivot('value', 'order', 'id')
        			->using(Pivot::class);
    } 
}

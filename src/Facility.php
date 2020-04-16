<?php

namespace Armincms\Facility;
 
use Illuminate\Database\Eloquent\Model; 
use Armincms\Localization\Contracts\Translatable; 
use Armincms\Localization\Concerns\HasTranslation; 
use Armincms\Concerns\Authorization;

class Facility extends Model implements Translatable
{
    use HasTranslation, Authorization; 

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "facility_facilities"; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guard = [
    ]; 

    public static $facilitate = null; 

    /**
     * Get the translation database.
     * 
     * @return string
     */
    public function getTranslationTable()
    {
        return 'facility_translations';
    }

	/**
     * summary
     */
    public function facilitates()
    {
        return $this->morphedByMany(
        	static::$facilitate ?? static::class, 'facilitate', 'facility_facilitate'
        );
    }

    /**
     * summary
     */
    public static function setFacilitate(string $facilitate)
    {
        static::$facilitate = $facilitate;

        return new static;
    } 

    /**
     * Get Translation model instance.
     * 
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getTranslationModel()
    {
        return new Translation;
    }
}

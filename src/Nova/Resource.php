<?php

namespace Armincms\Facility\Nova;

use Armincms\Nova\Resource as ArminResource; 
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Http\Request;  
use OwenMelbz\RadioField\RadioButton;  
use Superlatif\NovaTagInput\Tags;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\ID;
use Armincms\Localization\LocaleHelper;

abstract class Resource extends ArminResource 
{   
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Armincms\\Facility\\Facility';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'label';

    /**
     * The relationships that should be eager loaded when performing an index query.
     *
     * @var array
     */
    public static $with = [];

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'resource'
    ]; 

    /**
     * The columns that should be searched in the translation table.
     *
     * @var array
     */
    public static $searchTranslations = [
        'label'
    ];  

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    { 
    	$relatedResource = static::relatedResource();

    	return [
            ID::make()->sortable(), 

    		Select::make(__("Resource"), "resource")->options([
    				$relatedResource => $relatedResource::label()
    			])
    			->required()
    			->rules('required') 
    			->resolveUsing(function($value) {
    				return $value ?? static::relatedResource();
    			})
    			->displayUsingLabels()
    			->onlyOnForms(),  

            RadioButton::make(__("Value"), 'field')->options([
                Fields\Boolean::class       => __("Optional"),
                Fields\Select::class        => __("Selective"),
                Fields\Multiselect::class   => __("Multi Selective"),
                Fields\Number::class        => __("Number"),
                Fields\Text::class          => __("Text"),
            ])
            ->default(Fields\Boolean::class)
            ->marginBetween()
            ->toggle($this->toggles()),  
            
            $this->translatable([
                Tags::make(__("Options"), "options"),

                Text::make(__('Label'), 'label')
                    ->sortable()
                    ->required(),

                Text::make(__('Help'), 'help')
                    ->hideFromIndex(),
            ]),

            Text::make($relatedResource::label(), function() {
                return $this->facilitates->count();
            }),  
    	];
    }

    public function toggles()
    {
        return collect([
            Fields\Boolean::class => [], 
            Fields\Number::class => [],
            Fields\Text::class => [],
        ])->map(function() {
            return collect(LocaleHelper::activeLocales())->pluck('locale')->map(function($locale){
                return "options::{$locale}";
            })->all();
        })->all();
    }

    /**
     * Get a fresh instance of the model represented by the resource.
     *
     * @return mixed
     */
    public static function newModel()
    {
        $model = static::$model;
        $relatedResource = static::relatedResource();  

        return $model::setFacilitate($relatedResource::$model);
    } 

    /**
     * Build an "index" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->whereResource(static::relatedResource());
    } 

    /**
     * Related resource class
     * 
     * @return string 
     */
    abstract public static function relatedResource(): string;
}

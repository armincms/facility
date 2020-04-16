<?php

namespace Armincms\Facility\Http\Controllers;

use Illuminate\Routing\Controller;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Http\Resources\ConditionallyLoadsAttributes;
use Armincms\Facility\Facility;
use Armincms\Facility\Nova\Fields\Multiselect;
use Armincms\Facility\Nova\Fields\Boolean;
use Armincms\Facility\Nova\Fields\Select;
use Armincms\Facility\Nova\Fields\Number;
use Armincms\Facility\Nova\Fields\Text;

class AttachableController extends Controller
{

    /**
     * List the pivot fields for the given resource and relation.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function handle(NovaRequest $request)
    {   
        $resource = $request->resourceId ? $request->findResourceOrFail() : $request->newResource();

        $field = $this->relatableField($request, $resource); 

        $resource->load($request->relation);

        return Facility::whereIn('field', $field->matchingFields())->get()
        ->map(function($facility) use ($field, $request, $resource) {  
            return tap($this->resolveField($facility), function($field) use ($facility, $request, $resource) {  
                if(method_exists($field, 'options')) {
                    $field->options(collect($facility->options)->map->text);
                } 

                $field->resolve(
                    $resource->{$request->relation}->where('id', $facility->id)->pluck('pivot')->first()
                );
            });
        })->sortBy($field->sortCallback)->values(); 
    } 

    public function resolveField($facility)
    {
        return $facility->field::make($facility->label, "__[{$facility->id}]", function($value, $resource){
            return $value ?? optional($resource)->value;
        });
    }

    public function relatableField(NovaRequest $request, $resource)
    {
        return with($this->availableFields($request, $resource), function($fields) use ($request) {
            return $fields->first(function($field) use ($request) {
                return $field->attribute === $request->attribute;
            });
        });
    }

    public function availableFields(NovaRequest $request, $resource)
    {
        if($request->isCreateOrAttachRequest()) {
            return $request->creationFields($request);
        } elseif ($request->isUpdateOrUpdateAttachedRequest()) {
            return  $resource->updateFields($request);
        }

        return $resource->detailFields($request);
    }
}

<?php

namespace App\Models\Traits;

use ErrorException;
use Illuminate\Database\Eloquent\Relations\Relation;
use ReflectionClass;
use ReflectionMethod;

trait RelationshipsTrait
{
    public function relationships()
    {
        $model = new static;
        $methods = collect((new ReflectionClass($model))->getMethods(ReflectionMethod::IS_PUBLIC));

        $relationships = $methods->filter(function (ReflectionMethod $method) use ($model) {
            return $method->class == get_class($model) && empty($method->getParameters()) && $method->getName() != __FUNCTION__;
        })->mapWithKeys(function (ReflectionMethod $method) use ($model) {

            try {
                $return = $method->invoke($model);

                if ($return instanceof Relation) {
                    return [
                        $method->getName() => [
                            'type' => (new ReflectionClass($return))->getShortName(),
                            'model' => (new ReflectionClass($return->getRelated()))->getName()
                        ]
                    ];
                }
            } catch (ErrorException $e) {
            }
        });

        return $relationships->toArray();
    }
}
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

        try {
            $methods = collect((new ReflectionClass($model))->getMethods(ReflectionMethod::IS_PUBLIC));
        } catch (\ReflectionException $e) {
            $methods = collect();
        }

        $relationships = $methods->filter(function (ReflectionMethod $method) use ($model) {
            return $method->class == get_class($model) && empty($method->getParameters()) && $method->getName() != __FUNCTION__;
        })->filter(function ($method) use ($model) {
            try {
                return $method->invoke($model) instanceof Relation;
            } catch (ErrorException $e) {
                return false;
            }
        })->mapWithKeys(function (ReflectionMethod $method) use ($model) {
            $returnObj = $method->invoke($model);

            return [
                $method->getName() => [
                    'type' => (new ReflectionClass($returnObj))->getShortName(),
                    'model' => (new ReflectionClass($returnObj->getRelated()))->getName()
                ]
            ];
        });

        return $relationships->toArray();
    }
}
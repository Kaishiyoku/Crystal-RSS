<?php

namespace App\Models\Extensions;

use App\Enums\StyleType;
use App\Models\Traits\RelationshipsTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Extensions\ColoredModel
 *
 * @property-write mixed $raw
 * @property string $color
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extensions\ColoredModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extensions\ColoredModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Extensions\ColoredModel query()
 * @mixin \Eloquent
 */
class ColoredModel extends Model
{
    use RelationshipsTrait;

    public function getColor()
    {
        return $this->color ?? 'inherit';
    }

    public function getStyle($styleType = null)
    {
        $coloredModelRelationships = array_filter($this->relationships(), function ($relationship) {
            return $relationship['type'] == 'BelongsTo' && new $relationship['model'] instanceof ColoredModel;
        });

        $model = $this;

        // if color is null and there is a parent relation return its value instead
        if ($this->color == null && count($coloredModelRelationships) > 0) {
            $model = $this->{array_first(array_keys($coloredModelRelationships))};
        }

        if ($styleType === null || $styleType->is(StyleType::COLOR)) {
            return 'style="color: ' . $model->getColor() . '"';
        }

        if ($styleType->is(StyleType::BORDER)) {
            return 'style="border-left: .25rem solid ' . $model->getColor() . ' !important"';
        }
    }
}

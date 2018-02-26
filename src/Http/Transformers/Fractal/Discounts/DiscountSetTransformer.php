<?php
namespace GetCandy\Http\Transformers\Fractal\Discounts;

use Carbon\Carbon;
use GetCandy\Api\Discounts\Models\Discount;
use GetCandy\Api\Discounts\Models\DiscountCriteriaSet;
use GetCandy\Http\Transformers\Fractal\BaseTransformer;

class DiscountSetTransformer extends BaseTransformer
{
    protected $availableIncludes = [
        'items'
    ];

    public function transform(DiscountCriteriaSet $set)
    {
        return [
            'id' => $set->encodedId(),
            'scope' => $set->scope,
            'outcome' => (bool) $set->outcome
        ];
    }

    public function includeItems(DiscountCriteriaSet $set)
    {
        return $this->collection($set->items, new DiscountItemTransformer);
    }
}

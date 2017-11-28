<?php
namespace GetCandy\Api\Discounts\Models;

use GetCandy\Api\Scaffold\BaseModel;

class DiscountReward extends BaseModel
{
    protected $fillable = ['payload', 'type'];

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }
}

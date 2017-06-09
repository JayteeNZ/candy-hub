<?php

namespace GetCandy\Api\Attributes\Models;

use GetCandy\Api\Products\Models\Product;
use GetCandy\Api\Scaffold\BaseModel;

class Attribute extends BaseModel
{
    protected $hashids = 'attribute';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'handle',
        'position',
        'variant',
        'searchable',
        'filterable'
    ];

    public function group()
    {
        return $this->belongsTo(AttributeGroup::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withTimestamps();
    }
}
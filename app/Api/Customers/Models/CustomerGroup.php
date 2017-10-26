<?php

namespace GetCandy\Api\Customers\Models;

use GetCandy\Api\Products\Models\Product;
use GetCandy\Api\Collections\Models\Collection;
use GetCandy\Api\Scaffold\BaseModel;
use GetCandy\Api\Categories\Models\Category;
use GetCandy\Api\Auth\Models\User;

class CustomerGroup extends BaseModel
{
    /**
     * @var string
     */
    protected $hashids = 'main';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * @return mixed
     */
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('visible', 'purchasable');
    }

    /**
     * @return mixed
     */
    public function collections()
    {
        return $this->belongsToMany(Collection::class)->withPivot('visible', 'purchasable');
    }

    /**
     * @return mixed
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class)->withPivot('visible', 'purchasable');
    }
}

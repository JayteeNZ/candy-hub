<?php

namespace GetCandy\Http\Transformers\Fractal\Categories;

use GetCandy\Api\Categories\Models\Category;
use GetCandy\Http\Transformers\Fractal\BaseTransformer;
use GetCandy\Http\Transformers\Fractal\Routes\RouteTransformer;

class CategoryFancytreeTransformer extends BaseTransformer
{

    protected $defaultIncludes = [];

    public function transform(Category $category)
    {
        $data = [
            'id' => $category->encodedId(),
            'key' => $category->encodedId(),
            'attribute_data' => $category->attribute_data,
            'hasChildren' => $category->hasChildren(),
            'lazy' => $category->hasChildren(),
            'productCount' => $category->getProductCount()
        ];

        return $data;
    }
}

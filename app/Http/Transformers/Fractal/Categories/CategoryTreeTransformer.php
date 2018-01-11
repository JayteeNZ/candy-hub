<?php

namespace GetCandy\Http\Transformers\Fractal\Categories;

use GetCandy\Http\Transformers\Fractal\BaseTransformer;
use Illuminate\Support\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection as FractalCollection;

class CategoryTreeTransformer extends BaseTransformer
{
    public function transform(Collection $categories)
    {
        return $categories->toArray();
    }

    // protected function addDescendant($category, $descendant)
    // {
    //     $categor
    // }

    protected function includeCategory($category)
    {
        $resource = new Item($category, new CategoryTransformer);
        $rootScope = app()->fractal->createData($resource);
        return $rootScope->toArray();
    }

    protected function includeCategories($categories)
    {
        $resource = new FractalCollection($categories, new CategoryTransformer);
        $rootScope = app()->fractal->createData($resource);
        return $rootScope->toArray();
    }
}

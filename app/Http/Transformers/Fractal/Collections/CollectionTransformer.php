<?php

namespace GetCandy\Http\Transformers\Fractal\Collections;

use GetCandy\Api\Products\Models\Product;
use GetCandy\Api\Traits\IncludesAttributes;
use GetCandy\Api\Collections\Models\Collection;
use GetCandy\Api\Attributes\Models\AttributeGroup;
use GetCandy\Http\Transformers\Fractal\BaseTransformer;
use GetCandy\Http\Transformers\Fractal\Assets\AssetTransformer;
use GetCandy\Http\Transformers\Fractal\Routes\RouteTransformer;
use GetCandy\Http\Transformers\Fractal\Channels\ChannelTransformer;
use GetCandy\Http\Transformers\Fractal\Products\ProductTransformer;
use GetCandy\Http\Transformers\Fractal\Customers\CustomerGroupTransformer;

class CollectionTransformer extends BaseTransformer
{
    use IncludesAttributes;

    protected $defaultIncludes = [
        'routes'
    ];

    /**
     * @var Array
     */
    protected $availableIncludes = [
        'assets',
        'attribute_groups',
        'products',
        'channels',
        'customer_groups'
    ];

    /**
     * Decorates the product object for viewing
     * @param  Collection $collection
     * @return Array
     */
    public function transform(Collection $collection)
    {
        return [
            'id' => $collection->encodedId(),
            'attribute_data' => $collection->attribute_data,
            'thumbnail' => $this->getThumbnail($collection)
        ];
    }

    /**
     * Includes the products for the collection
     * @param  Collection $collection
     * @return League\Fractal\Resource\Collection
     */
    public function includeProducts(Collection $collection)
    {
        return $this->collection($collection->products, new ProductTransformer);
    }

    public function includeAssets(Collection $collection)
    {
        return $this->collection($collection->assets()->orderBy('position', 'asc')->get(), new AssetTransformer);
    }

    /**
     * @param Product $product
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeChannels(Collection $collection)
    {
        $channels = app('api')->channels()->getChannelsWithAvailability($collection, 'collections');
        return $this->collection($channels, new ChannelTransformer);
    }

    /**
     * @param Product $product
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeCustomerGroups(Collection $collection)
    {
        $groups = app('api')->customerGroups()->getGroupsWithAvailability($collection, 'collections');
        return $this->collection($groups, new CustomerGroupTransformer);
    }

    /**
     * @param Product $product
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeRoutes(Collection $collection)
    {
        return $this->collection($collection->routes, new RouteTransformer);
    }
}

<?php

namespace GetCandy\Http\Transformers\Fractal\Products;

use GetCandy\Api\Products\Models\ProductFamily;
use GetCandy\Http\Transformers\Fractal\Attributes\AttributeTransformer;
use GetCandy\Http\Transformers\Fractal\Associations\AssociationGroupTransformer;
use GetCandy\Http\Transformers\Fractal\BaseTransformer;
use GetCandy\Api\Products\Models\ProductAssociation;

class ProductAssociationTransformer extends BaseTransformer
{
    protected $defaultIncludes = [
        'association', 'type'
    ];

    public function transform(ProductAssociation $model)
    {
        return [
            'id' => $model->encodedId()
        ];
    }

    public function includeAssociation(ProductAssociation $model)
    {
        return $this->item($model->association, new ProductTransformer);
    }

    public function includeType(ProductAssociation $model)
    {
        return $this->item($model->group, new AssociationGroupTransformer);
    }
}

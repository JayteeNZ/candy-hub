<?php

namespace GetCandy\Http\Transformers\Fractal\Pages;

use GetCandy\Api\Pages\Models\Page;
use GetCandy\Http\Transformers\Fractal\Attributes\AttributeGroupTransformer;
use GetCandy\Http\Transformers\Fractal\BaseTransformer;

class PageTransformer extends BaseTransformer
{
    protected $availableIncludes = [
        'element'
    ];

    public function transform(Page $page)
    {
        return [
            'id' => $page->encodedId(),
            'slug' => $page->slug,
            'seo_title' => $page->seo_title,
            'seo_description' => $page->seo_description
        ];
    }

    public function includeElement(Page $page)
    {
        return $this->item($page->element, new $page->element->transformer);
    }
}

<?php

namespace GetCandy\Http\Transformers\Fractal\Users;

use Spatie\Permission\Models\Role;
use League\Fractal\TransformerAbstract;
use GetCandy\Http\Transformers\Fractal\BaseTransformer;

class UserRoleTransformer extends BaseTransformer
{
    public function transform(Role $role)
    {
        return [
            'name' => $role->name,
            'guard' => $role->guard_name
        ];
    }
}

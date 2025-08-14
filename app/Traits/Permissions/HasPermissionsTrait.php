<?php

namespace App\Traits\Permissions;

use App\Models\User\Permission;
use App\Models\User\Role;

trait HasPermissionsTrait{

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    protected function hasPermission($permission)
    {
        return (bool) $this->permissions->where('name', $permission->name)->count();
    }

    public function hasRole(...$roles)
    {
        foreach ($roles as $role) {
            if ($this->roles->contains('name', $role)) {
                return true;
            }
        }
        return false;
    }


}
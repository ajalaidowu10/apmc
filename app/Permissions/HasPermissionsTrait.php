<?php 
  namespace  App\Permissions;

  use App\Permission;
  use App\Role;

  trait HasPermissionsTrait
  {
      public function givePermissionsTo(array $permissions) 
      {
        $permissions = $this->getAllPermissions($permissions);
        if($permissions === null) {
          return $this;
        }
        $this->permissions()->saveMany($permissions);
        return $this;
      }

      public function withdrawPermissionsTo(array $permissions ) 
      {
        $permissions = $this->getAllPermissions($permissions);
        $this->permissions()->detach($permissions);
        return $this;
      }

      public function refreshPermissions(array $permissions ) 
      {
        $this->permissions()->detach();

        $permissions = $this->getAllPermissions($permissions);
        if($permissions === null) {
          return $this;
        }
        $this->permissions()->saveMany($permissions);
        return $this;
      }

      public function hasPermissionTo($permission) 
      {
        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
      }

      public function hasPermissionThroughRole($permission) 
      {
        if ($permission->roles) {
            foreach ($permission->roles as $role) 
            {
              if($this->roles->contains($role)) {
                return true;
              }
            }
        } 
        
        return false;
      }

      public function hasRole(array $roles ) 
      {
        foreach ($roles as $role) {
          if ($this->roles->contains('name', $role)) {
            return true;
          }
        }
        return false;
      }

      public function roles() 
      {
        return $this->belongsToMany(Role::class,'admins_roles');
      }

      public function permissions() 
      {
        return $this->belongsToMany(Permission::class,'admins_permissions');
      }

      protected function hasPermission($permission) 
      {
        return (bool) $this->permissions->where('slug', $permission->slug)->count();
      }

      protected function getAllPermissions(array $permissions) 
      {
        return Permission::whereIn('slug',$permissions)->get();
      }
  }




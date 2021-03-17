<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{   
    protected $fillable = [
        'module_id', 'name', 'slug', 'link',
    ];
    
    public function roles()
    {
      return $this->belongsToMany(Role::class, 'roles_permissions');
    }
    
    public function admins()
    {
      return $this->belongsToMany(Admin::class, 'admins_permissions');
    }

    public function module()
    {
     return $this->belongsTo('App\Module');
    }
}

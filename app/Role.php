<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Permissions\HasPermissionsTrait;

class Role extends Model
{
    use HasPermissionsTrait;

    protected $fillable = [
        'name', 
    ];

    public function permissions()
    {
      return $this->belongsToMany(Permission::class, 'roles_permissions');
    }

    public function admins()
    {
      return $this->belongsToMany(Admin::class, 'admins_permissions');
    }
}

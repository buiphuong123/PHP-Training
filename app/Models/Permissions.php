<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    use HasFactory;
    protected $table = "permissions";
    public function users() {
        return $this->belongsToMany('App\Models\User', 'users_permissions', 'permission_id', 'user_id');
     }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model
{
    protected $table = 'admin_users';

    public function store()
    {
        return $this->belongsToMany('App\Models\Store', 'store_admin_user', 'user_id', 'store_id');
    }
}

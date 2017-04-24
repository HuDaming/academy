<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    public function users()
    {
        return $this->belongsToMany('Encore\Admin\Auth\Database\Administrator', 'store_admin_user', 'store_id', 'user_id')
            ->withPivot('level')
            ->withTimestamps();
    }
}

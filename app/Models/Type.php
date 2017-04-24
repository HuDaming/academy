<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    public $timestamps = false;

    public function goods()
    {
        return $this->hasMany('App\Models\Goods', 'class_id', 'id');
    }
}

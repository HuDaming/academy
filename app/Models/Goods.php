<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    public function magazines()
    {
        return $this->hasMany('App\Models\Magazine');
    }

    public function setAttachAttribute($attach)
    {
        if (is_array($attach)) {
            $this->attributes['attach'] = json_encode($attach);
        }
    }

    public function getPicturesAttribute($attach)
    {
        return json_decode($attach, true);
    }
}

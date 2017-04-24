<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Magazine extends Model
{
    protected $fillable = ['classes', 'body', 'completed_at'];

    public function goods()
    {
        return $this->belongsTo('App\Models\Goods');
    }
}

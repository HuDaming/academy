<?php

namespace App\Http\Controllers;

use App\Models\Goods;
use App\Models\Type;;
use Illuminate\Http\Request;

class GoodsController extends Controller
{
    public function index($id = null)
    {
        if ($id == null) {
            return response(Type::with('goods')->get());
        } else {
            return response(Goods::where('id', $id)->get());
        }
    }
}

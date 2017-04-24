<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App;
use App\Contracts\TestContract;

class TestController extends Controller
{
    public function __construct(TestContract $test)
    {
        $this->test = $test;
    }

    public function index()
    {
        $test = App::make('test');
        $test->callMe('TestController');
//        $this->test->callMe('TestController');
    }
}

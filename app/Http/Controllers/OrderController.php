<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function show(string $date,int $num){
        return view('order.show',compact('date','num'));
    }
}

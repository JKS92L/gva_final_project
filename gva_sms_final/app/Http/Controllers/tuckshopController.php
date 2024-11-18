<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class tuckshopController extends Controller
{
    //
    public function viewSales(){
        return view('backend.tuckshop.tuckshop-sales');
    }
}

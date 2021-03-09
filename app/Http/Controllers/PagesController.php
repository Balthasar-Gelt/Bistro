<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class PagesController extends Controller
{
    public function index(){

        return view('pages/welcome');
    }

    public function makeOrder(){

        $categories = Category::all()->pluck('name','id');

        return view('pages/make-order', compact('categories'));
    }

}

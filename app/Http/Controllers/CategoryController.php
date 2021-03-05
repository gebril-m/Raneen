<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $allcategories = Category::whereIsActive(true)->get();
        return view('category.index',compact('allcategories'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;

class ReviewController extends Controller
{
    
    function setRating(Request $request){
        $uid = auth()->user()->id;
        # add review
        $request->merge(['user_id' => $uid]);
        Review::create($request->all());
        return ['status' => 1];
    }

}

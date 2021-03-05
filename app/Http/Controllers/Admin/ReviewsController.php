<?php

namespace App\Http\Controllers\Admin;

use App\Country;
use App\Language;
use App\Page;
use App\Product;
use App\Review;
use App\Rules\UniqueReview;
use App\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\User;
use Hash;
use DataTables;
use Spatie\Permission\Models\Role;

class ReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->languages = Language::all();
        view()->share('languages', $this->languages);
    }

    public function index()
    {
        return view ('admin.reviews.index');
    }

    public function data($controller = false){

        $reviews = Review::query();
        $product_reviews = Review::query()
            ->select('item_id')
            ->get();



        // if (!\request()->get('length')) {
        //     $reviews->limit(10);
        // }

        if ($controller) {
            $reviews->limit(10)->orderBy('id','DESC');
        }




        return DataTables::eloquent($reviews)
        ->addColumn('review_title', function (Review $Review){
            return $Review->review_title;
        })
        ->addColumn('review', function (Review $Review){
            return $Review->review;
        })
        ->addColumn('stars', function (Review $Review){
            return $Review->rate;
        })
        ->addColumn('options', function (Review $Review){
            $back = '';
            if($Review->approved == 0){
                $back .= \Form::open(['url'=>route('admin.reviews.approve','id='.$Review->id), 'class' => 'd-inline', 'onclick' => 'return confirm("Are you sure?")']);
                $back .= method_field('GET');
                $back .= \Form::submit('Approve', ['class' => 'btn btn-outline-success sa-success']);
                $back .= \Form::close();
            }else{
                $back .= \Form::open(['url'=>route('admin.reviews.disapprove','id='.$Review->id), 'class' => 'd-inline', 'onclick' => 'return confirm("Are you sure?")']);
                $back .= method_field('GET');
                $back .= \Form::submit('Refuse', ['class' => 'btn btn-outline-danger sa-warning']);
                $back .= \Form::close();
            }


            return $back;

        })->rawColumns(['options'])
        ->make();
    }

    // public function destroy(Review $Review)
    // {
    //     $Review->delete();
    //     return redirect()->route('admin.reviews.index');
    // }
    public function approve(Review $Review, Request $request)
    {
        $review = Review::find($request->input('id'));
        $review->approved = 1;
        $review->save();
        return redirect()->route('admin.reviews.index');
    }
    public function disapprove(Review $Review, Request $request)
    {
        $review = Review::find($request->input('id'));
        $review->approved = 0;
        $review->save();
        return redirect()->route('admin.reviews.index');
    }
}

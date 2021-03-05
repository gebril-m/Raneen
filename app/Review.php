<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id', 'item_id', 'rate', 'review_title', 'review', 'approved'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function product() {
        return Product::find($this->item_id);
    }

}

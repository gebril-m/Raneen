<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    protected $table = "category_translations";

    public function category() {
        return $this->belongsTo(Category::class);
    }
}

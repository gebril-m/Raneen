<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\DealSection;
class DealSectionTranslation extends Model
{
    protected $table = "deal_sections_translations";

    public function dealsection() {
        return $this->belongsTo(DealSection::class);
    }
    public function product_ids() {
        return DealSection::find($this->deal_section_id);
    }
}

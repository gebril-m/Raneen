<?php

namespace App\Imports;

use App\Brand;
use App\BrandTranslation;
use Maatwebsite\Excel\Concerns\ToModel;

class BrandsImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        if($row[0] == 'Code') return;

//        $brand                = new Brand();
//        $brand->name          = $row[0];
//        $brand->save();
//
//        $brand_translation                = new BrandTranslation();
//        $brand_translation->name          = $row[1];
//        $brand_translation->locale          = 'en';
//        $brand_translation->brand_id          = $brand->id;
//        $brand_translation->save();
        $rules_validation=[];
        $logo = $row[9];
        if(isset($logo)){
            if(strpos($logo,'http') !== false){
                $logo = $row[9];
            }else{
                $logo = $row[9];
            }
        }
        if(!isset($row[0])){
            $rules_validation[0]='The Category Code is required';
            session()->flash('rules_validation',$rules_validation);
            return [];
        }
        $brand_obj = [];
        $brand_id = 0;
        $brand_ar = BrandTranslation::where('name','=',$row[1])
            ->where('locale','=','ar')
            ->get();
        $brand_en = BrandTranslation::where('name','=',$row[2])
            ->where('locale','=','en')
            ->get();

        if(count($brand_ar) > 0 || count($brand_en) > 0){
            if(count($brand_ar) > 0){
                $brand_id = $brand_ar[0]->brand_id;
            }
            if(count($brand_en) > 0){
                $brand_id = $brand_en[0]->brand_id;
            }
            $get_brand = Brand::find($brand_id);
            if(isset($get_brand)){
                $get_brand->logo = $logo;
                
                    if ($get_brand->code != $row[0]) {
                        $notunique=Brand::where('code',$row[0])->first();
                        if ($notunique) {
                            $rules_validation[0]='This Brand '.$row[1].'  Code "'.$row[0].'" already used';
                            session()->flash('rules_validation',$rules_validation);
                            return [];
                        }
                    }
                    $get_brand->code=$row[0];
                
                if (count($rules_validation)>0) {
                    
                    session()->flash('rules_validation',$rules_validation);
                    return[];
                }
                $get_brand->save();
            }else{
                $notunique=Brand::where('code',$row[0])->first();
                if ($notunique) {
                    $rules_validation[0]='This Brand '.$row[1].'  Code "'.$row[0].'" already used';
                    session()->flash('rules_validation',$rules_validation);
                    return [];
                }
                $brand = new Brand();
                $brand->id = $brand_id;
                $brand->logo = $logo;             
                $brand->code=$row[0];
                $brand->save();
            }
        }else{
            $brand = new Brand();
            $brand->logo = $logo;
            $notunique=Brand::where('code',$row[0])->first();
            if ($notunique) {
                $rules_validation[0]='This Brand '.$row[1].'  Code "'.$row[0].'" already used';
                session()->flash('rules_validation',$rules_validation);
                return [];
            }
            $brand->code=$row[0];
            
            $brand->save();
            $brand_id = $brand->id;
        }   
        $brand_ar = BrandTranslation::where('brand_id','=',$brand_id)->where('locale','=','ar')->get()->first(); 
        $brand_en = BrandTranslation::where('brand_id','=',$brand_id)->where('locale','=','en')->get()->first();

        if($brand_ar){
            $brand_ar->name = $row[1];
            $brand_ar->meta_title = $row[3];
            $brand_ar->meta_keywords = $row[4];
            $brand_ar->meta_description = $row[5];
            $brand_ar->save();
        }else{
            $brand_ar = new BrandTranslation;
            $brand_ar->name = $row[1];
            $brand_ar->brand_id = $brand_id;
            $brand_ar->locale = "ar";
            $brand_ar->meta_title = $row[3];
            $brand_ar->meta_keywords = $row[4];
            $brand_ar->meta_description = $row[5];
            $brand_ar->save();
        }
        if($brand_en){
            $brand_en->name =  $row[2];
            $brand_en->meta_title = $row[6];
            $brand_en->meta_keywords = $row[7];
            $brand_en->meta_description = $row[8];
            $brand_en->save();
        }else{
            $brand_en = new BrandTranslation;
            $brand_en->name = $row[2];
            $brand_en->brand_id = $brand_id;
            $brand_en->locale = "en";
            $brand_en->meta_title = $row[6];
            $brand_en->meta_keywords = $row[7];
            $brand_en->meta_description = $row[8];
            $brand_en->save();
        }
        


        // if ($brand_ar) {
        //     $brand_id = $brand_ar->brand_id;
        // } else {
        //     $brand_ar = new BrandTranslation();
        //     $brand_ar->locale = 'ar';
        //     $brand_ar->name = $row[0];
        // }

        // $brand_en = BrandTranslation::where('name','=',$row[1])
        //     ->where('locale','=','en')
        //     ->first();

        // if ($brand_en) {
        //     $brand_id = $brand_en->brand_id;
        // } else {
        //     $brand_en = new BrandTranslation();
        //     $brand_en->locale = 'en';
        //     $brand_en->name = $row[1];
        // }

        // if ($brand_id == 0) {
        //     $brand = new Brand();
        //     $brand->save();

        //     $brand_id = $brand->id;
        //     $brand_ar->brand_id = $brand_id;
        //     $brand_en->brand_id = $brand_id;
        //     $brand_ar->save();
        //     $brand_en->save();
        // }else{
        //     $brand_ar->brand_id = $brand_id;
        //     $brand_en->brand_id = $brand_id;
        //     $brand_ar->save();
        //     $brand_en->save();
        // }

        # return $brand;
    }
}

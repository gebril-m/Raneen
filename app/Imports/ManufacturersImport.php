<?php

namespace App\Imports;

use App\Manufacturer;
use App\ManufacturerTranslation;
use Maatwebsite\Excel\Concerns\ToModel;

class ManufacturersImport implements ToModel
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
//        $brand_translation                = new ManufacturerTranslation();
//        $brand_translation->name          = $row[1];
//        $brand_translation->locale          = 'en';
//        $brand_translation->manufacturer_id          = $brand->id;
//        $brand_translation->save();
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
        }else{
            $notunique=Manufacturer::where('code',$row[0])->first();
            if ($notunique) {
                $rules_validation[0]='This Manufacturer '.$row[1].'  Code "'.$row[0].'" already used';
                session()->flash('rules_validation',$rules_validation);
                return [];
            }
        }
        $manufacturer_obj = [];
        $manufacturer_id = 0;
        $manufacturer_ar = ManufacturerTranslation::where('name','=',$row[1])
            ->where('locale','=','ar')
            ->get();
        $manufacturer_en = ManufacturerTranslation::where('name','=',$row[2])
            ->where('locale','=','en')
            ->get();

        if(count($manufacturer_ar) > 0 || count($manufacturer_en) > 0){
            if(count($manufacturer_ar) > 0){
                $manufacturer_id = $manufacturer_ar[0]->manufacturer_id;
            }
            if(count($manufacturer_en) > 0){
                $manufacturer_id = $manufacturer_en[0]->manufacturer_id;
            }
            $get_manufacturer = Manufacturer::find($manufacturer_id);
            if(isset($get_manufacturer)){
                $get_manufacturer->logo = $logo;
                $get_manufacturer->code = $row[0];
                $get_manufacturer->save();
            }else{
                $get_manufacturer = new Manufacturer();
                $get_manufacturer->id = $manufacturer_id;
                $get_manufacturer->logo = $logo;
                $get_manufacturer->code = $row[0];
                $get_manufacturer->save();
            }
            $get_manufacturer->logo = $logo;
            $get_manufacturer->code = $row[0];
            $get_manufacturer->save();
        }else{
            $brand = new Manufacturer();
            $brand->logo = $logo;
            $brand->code = $row[0];
            $brand->save();
            $manufacturer_id = $brand->id;
        }   
        $manufacturer_ar = ManufacturerTranslation::where('manufacturer_id','=',$manufacturer_id)->where('locale','=','ar')->get()->first(); 
        $manufacturer_en = ManufacturerTranslation::where('manufacturer_id','=',$manufacturer_id)->where('locale','=','en')->get()->first();

        if($manufacturer_ar){
            $manufacturer_ar->name = $row[1];
            $manufacturer_ar->slug = $row[9];
            $manufacturer_ar->meta_title = $row[3];
            $manufacturer_ar->meta_keywords = $row[4];
            $manufacturer_ar->meta_description = $row[5];
            $manufacturer_ar->save();
        }else{
            $manufacturer_ar = new ManufacturerTranslation;
            $manufacturer_ar->name = $row[1];
            $manufacturer_ar->slug = $row[9];
            $manufacturer_ar->manufacturer_id = $manufacturer_id;
            $manufacturer_ar->locale = "ar";
            $manufacturer_ar->meta_title = $row[3];
            $manufacturer_ar->meta_keywords = $row[4];
            $manufacturer_ar->meta_description = $row[5];
            $manufacturer_ar->save();
        }
        if($manufacturer_en){
            $manufacturer_en->name =  $row[2];
            $manufacturer_en->slug =  $row[10];
            $manufacturer_en->meta_title = $row[6];
            $manufacturer_en->meta_keywords = $row[7];
            $manufacturer_en->meta_description = $row[8];
            $manufacturer_en->save();
        }else{
            $manufacturer_en = new ManufacturerTranslation;
            $manufacturer_en->name = $row[2];
            $manufacturer_en->slug = $row[10];
            $manufacturer_en->manufacturer_id = $manufacturer_id;
            $manufacturer_en->locale = "en";
            $manufacturer_en->meta_title = $row[6];
            $manufacturer_en->meta_keywords = $row[7];
            $manufacturer_en->meta_description = $row[8];
            $manufacturer_en->save();
        }
    }
}

<?php

namespace App\Exports;

use App\Brand;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BrandsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        $_brands = Brand::get();
        $brands = [];
        foreach ($_brands as $brand) {
            $brands[] = [
                $brand->code,
                $brand->name,
                $brand->translate('en')->name,
                $brand->get_seo('ar','meta_title',$brand->id),
                $brand->get_seo('ar','meta_keywords',$brand->id),
                $brand->get_seo('ar','meta_description',$brand->id),
                $brand->get_seo('en','meta_title',$brand->id),
                $brand->get_seo('en','meta_keywords',$brand->id),
                $brand->get_seo('en','meta_description',$brand->id),
                $brand->logo,
                # $brand->created_at,
                # $brand->updated_at,
            ];
        }

        return collect($brands);
    }

    public function headings(): array
    {
        return [
            'Code',
            'Name',
            'Name En',
            'Meta Title',
            'Meta Keywords',
            'Meta Description',
            'Meta Title En',
            'Meta Keywords En',
            'Meta Description En',
            'Logo',
            
            # 'Created ar',
            # 'Charge',
        ];
    }
}

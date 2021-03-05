<?php

namespace App\Exports;

use App\Manufacturer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ManufacturersExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        $_manufacturers = Manufacturer::get();
        $manufacturers = [];
        foreach ($_manufacturers as $manufacturer) {
            $manufacturers[] = [
                $manufacturer->code,
                $manufacturer->name,
                $manufacturer->translate('en')->name ?? '',
                $manufacturer->get_seo('ar','meta_title',$manufacturer->id),
                $manufacturer->get_seo('ar','meta_keywords',$manufacturer->id),
                $manufacturer->get_seo('ar','meta_description',$manufacturer->id),
                $manufacturer->get_seo('en','meta_title',$manufacturer->id),
                $manufacturer->get_seo('en','meta_keywords',$manufacturer->id),
                $manufacturer->get_seo('en','meta_description',$manufacturer->id),
                $manufacturer->logo,
                $manufacturer->translate('ar')->slug,
                $manufacturer->translate('en')->slug,
                # $brand->logo,
                # $brand->created_at,
                # $brand->updated_at,
            ];
        }

        return collect($manufacturers);
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
            'Slug',
            'Slug En',
            # 'Logo',
            # 'Created ar',
            # 'Charge',
        ];
    }
}

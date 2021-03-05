<?php

namespace App\Exports;

use App\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CategoriesExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        $_categories = Category::get();
        $categories = [];
        foreach ($_categories as $category) {
            $categories[] = [
                # $brand->id,
                $category->code,
                $category->name,
                $category->translate('en')->name,
                $category->slug,
                $category->translate('en')->slug,
                $category->parent ? $category->parent->translate('en')->slug : '',
                $category->get_seo('ar','meta_title',$category->id),
                $category->get_seo('ar','meta_keywords',$category->id),
                $category->get_seo('ar','meta_description',$category->id),
                $category->get_seo('en','meta_title',$category->id),
                $category->get_seo('en','meta_keywords',$category->id),
                $category->get_seo('en','meta_description',$category->id),
                $category->banner,
                $category->is_active,
                $category->in_header ? 1 : 0,
                # $brand->logo,
                # $brand->created_at,
                # $brand->updated_at,
            ];
        }

        return collect($categories);
    }

    public function headings(): array
    {
        return [
            'Code',
            'Name',
            'Name En',
            'slug',
            'slug En',
            'Parent',
            'Meta Title',
            'Meta Keywords',
            'Meta Description',
            'Meta Title En',
            'Meta Keywords En',
            'Meta Description En',
            'icon',
            'is_active',
            'in_header',
            # 'Logo',
            # 'Created ar',
            # 'Charge',
        ];
    }
}

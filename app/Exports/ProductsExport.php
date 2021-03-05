<?php

namespace App\Exports;

use App\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        $_products = Product::get();

        $products = [];
        foreach ($_products as $product) {

            $products[] = [
                #$product->id,

                $product->translate('ar')? $product->translate('ar')->name: '',
                $product->translate('en')? $product->translate('en')->name: '',
                $product->translate('ar')? $product->translate('ar')->slug: '',
                $product->translate('en')? $product->translate('en')->slug: '',
                $product->translate('ar')? $product->translate('ar')->description: '',
                $product->translate('en')? $product->translate('en')->description: '',

                $product->stock,
                $product->minimum_stock,
                $product->price,
                $product->return_allowed ? 1 : 0,
                $product->return_duration,
                $product->on_sale ? 1 : 0,
                $product->before_price > 0 ? $product->before_price : 0 ,
                $product->is_hot,
                $product->hot_price,
                $product->hot_starts_at,
                $product->hot_ends_at,
                $product->categories && isset($product->categories[0]) ? $product->categories[0]->code ?? '' : '',
                $product->categories && isset($product->categories[0]) ? $product->categories[0]->translate('en')->name ?? '' : '',
                $product->brand ? $product->brand->code : '',
                $product->brand ? $product->brand->translate('en')->name : '',
                $product->manufacturer ? $product->manufacturer->code : '',
                $product->manufacturer && $product->manufacturer->translate('en') ? $product->manufacturer->translate('en')->name : '',
                $product->barcode,
                $product->axapta_code,
                $product->item_id,
                $product->get_seo('ar','meta_title',$product->id),
                $product->get_seo('ar','meta_keywords',$product->id),
                $product->get_seo('ar','meta_description',$product->id),
                $product->get_seo('en','meta_title',$product->id),
                $product->get_seo('en','meta_keywords',$product->id),
                $product->get_seo('en','meta_description',$product->id),
                $product->is_active ? 1 : 0,
                implode(",",$product->get_images($product->id)),
                $product->get_attributes($product->id),
                $product->get_attributes_value($product->id),
                $product->is_point,
            ];
        }
        return collect($products);
    }

    public function headings(): array
    {
        return [
            #'ID',
            'Name',
            'Name En',
            'Slug',
            'Slug En',
            'Description',
            'Description En',
            'stock',
            'minimum stock',
            'price',
            'return_allowed ?',
            'return_duration',
            'on_sale ?',
            'before_price',
            'is hot',
            'hot price',
            'hot starts at',
            'hot ends at',
            'category',
            'category en',
            'brand',
            'brand en',
            'manufacturer',
            'manufacturer en',
            'barcode',
            'axapta_code',
            'item_id',
            'Meta Title',
            'Meta Keywords',
            'Meta Description',
            'Meta Title En',
            'Meta Keywords En',
            'Meta Description En',
            'is active',
            'images',
            'attributes',
            'attributes value',
            # 'Logo',
            # 'Created ar',
            # 'Charge',
        ];
    }
}

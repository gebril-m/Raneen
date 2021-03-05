<?php 
namespace App\Reports;
use Illuminate\Http\Request;
use App\Order;
class ordersReport extends mainReport{

    function table(){
        return view('admin.reports.orders');
    }
    
    function tableResults(Request $request){
        
        $query = Order::query();
        
        $query->select('orders.*');
        // $query->leftJoin('product_translations', 'products.id', 'product_translations.product_id');
        // $query->where('product_translations.locale', 'ar');

        // if (\request()->get('brand')) {
        //     $query->where('brand_id', \request()->get('brand'));
        // }

        // if (\request()->get('manufacturer')) {
        //     $query->where('manufacturer_id', \request()->get('manufacturer'));
        // }

        // if (\request()->get('category')) {
        //     $query
        //         ->join('product_categories', 'product_categories.product_id', 'products.id')
        //         ->where('category_id', \request()->get('category'));
        // }

        return datatables()->of($query)
            // ->editColumn('product_translations.name', function (Product $product) {
            //     return $product->name . '<br />' . ($product->categories[0]->name ?? '');
            // })
            // ->editColumn('brand_manufacturer', function (Product $product) {
            //     return ($product->brand->name ?? '') . '<br />' . ($product->manufacturer->name ?? '');
            // })
            // ->editColumn('is_active', function (Product $product) {
            //     return $product->is_active ? '<span class="label label-info">Active</span>' : '<span class="label label-danger">Inactive</span>';
            // })
            // ->addColumn('options', function (Product $product) {

            //     $back = "";
            //     # $back .= '<a href="'. route('admin.products.show', $product->id) .'" class="btn waves-effect waves-light btn-outline-warning" title="edit">Show</a>';
            //     $back .= '&nbsp;<a href="'. route('admin.products.edit', $product->id) .'" class="btn waves-effect waves-light btn-outline-info" title="edit">Edit</a>&nbsp;';

            //     $back .= \Form::open(['url'=>route('admin.products.destroy', $product->id), 'class' => 'd-inline', 'onclick' => 'return confirm("Are you sure?")']);
            //     $back .= method_field('DELETE');
            //     $back .= \Form::submit('Delete', ['class' => 'btn btn-outline-danger sa-warning']);
            //     $back .= \Form::close();

            //     return $back;
            // })
            //->rawColumns(['options', 'brand_manufacturer', 'product_translations.name', 'is_active'])
            ->make(true);
    }
    
}

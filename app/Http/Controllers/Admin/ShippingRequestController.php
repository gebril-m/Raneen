<?php

namespace App\Http\Controllers\Admin;

use App\ShippingRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ShippingZone;
use App\ShippingCompany;
use App\Order;
use App\OrderProduct;
use DataTables;
use App\OrderStatus;
class ShippingRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function check($company,$order,$orderline){
        if($company != 0){
            $order_check = Order::find($order);
            $check = ShippingRequest::where('order_id','=',$order)->where('company_id','=',$company)->where('status','=','New')->get()->first();
            if($check){
                $exist_orderlines = explode(',',$check->order_lines_ids);
                array_push($exist_orderlines,$orderline);
                $check->order_lines_ids = implode(',',$exist_orderlines);
                $check->shipping_cost = $this->total_shippingcost($order_check,$company,[$exist_orderlines]);
                $check->save();
            }else{
                $new = new ShippingRequest;
                $new->company_id = $company;
                $new->order_id = $order;
                $new->order_lines_ids = $orderline;
                $new->address = $order_check->address;
                $new->status = "New";
                $new->shipping_cost = $this->total_shippingcost($order_check,$company,[$orderline]);
                $new->save();
            }
        }
        
    }
    public function total_shippingcost($order,$company,$orderline){
        $orderP = OrderProduct::whereIn('id',$orderline)->get();
        $weights = 0;
        $total_price = 0;
        foreach($orderP as $op){
            $weights += (($op->product->length*$op->product->width*$op->product->height)/3000)*$op->quantity;
            $total_price += $op->price_after;
        }
        $total_shipping = 0;
        $shipping_zone = ShippingZone::where('company_id','=',$company)->get();        
        $results = [];
        foreach($shipping_zone as $zone){
            if(in_array($order->state,json_decode($zone->areas))){
                $zone_id = $zone->id;
                $first_kg = $zone->first_kg;
                $additional_kg = $zone->additional_kg;
                $company_id = $zone->company_id;
                $company = ShippingCompany::find($company_id);
                $first_kg_number = $company->first_kg_number;
                $cod_values = explode(',',$zone->cod_values);


                $adds_kgs = $first_kg_number-(int)$weights;
                $adds_kgs = str_replace('-','',$adds_kgs);
                if((int)$weights > $first_kg_number){
                    $total_shipping += (int)$first_kg;
                    $total_shipping += $adds_kgs*$additional_kg;
                }
            }
            
            // Shipping Properties Checker
            if($company_id){
                $fuel = $company->fuel;
                $post = $company->post;
                $vat = $company->vat;
                $cod = $company->cod;
            }
    
            // COD Values Checker
            if($cod){
                $selected_cod = 0;
                $cods = explode(',',$cod);
                $i=0;
                foreach($cods as $item){
                    if($item <= $total_price){
                        $selected_cod = $i;
                    }
                    $i++;
                }
            }
            if(isset($selected_cod)){
                $cod = $cod_values[$selected_cod];
                if(strpos($cod,'%') !== false){
                    $total_shipping += $total_price*str_replace('%','',$cod)/100;
                }else{
                    $total_shipping += $cod;
                }
            }
    
            if($fuel){
                $total_shipping += $total_shipping*$fuel/100;
            }
            if($post){
                $total_shipping += $total_shipping*$post/100;
            }
            if($vat){
                $total_shipping += $total_shipping*$vat/100;
            }
        }
        return $total_shipping;
    }
    public function index()
    {
        return view ('admin.shipping-requests.index');
    }

    public function data($controller = false){

        $SRequests = ShippingRequest::query();

        // if (!\request()->get('length')) {
        //     $cities->limit(10);
        // }

        if ($controller) {
            $SRequests->limit(10)->orderBy('id','DESC');
        }

        return DataTables::eloquent($SRequests)
        ->addColumn('order_id', function (ShippingRequest $SRequest){
            return $SRequest->order_id;
        })
        ->addColumn('order_lines_ids', function (ShippingRequest $SRequest){
            $lines = explode(',',$SRequest->order_lines_ids);
            $orderP = OrderProduct::whereIn('id',$lines)->get();
            $text = "";
            if($orderP->count() > 0){
                foreach($orderP as $op){
                    $text .= "&nbsp;<span class='badge badge-info'>".$op->product->name." x ".$op->quantity."</span>&nbsp;";
                }
            }
            return $text;
        })
        ->addColumn('company_id', function (ShippingRequest $SRequest){
            return $SRequest->company->name;
        })
        ->addColumn('shipping_cost', function (ShippingRequest $SRequest){
            return $SRequest->shipping_cost;
        })
        ->addColumn('status', function (ShippingRequest $SRequest){
            return $SRequest->status;
        })
        ->addColumn('address', function (ShippingRequest $SRequest){
            return $SRequest->address;
        })
        ->addColumn('options', function (ShippingRequest $SRequest){

            $back = "";
            # $back .= '<a href="'. route('admin.products.show', $product->id) .'" class="btn waves-effect waves-light btn-outline-warning" title="edit">Show</a>';
            if($SRequest->status == 'New'){
                $back .= '&nbsp;<a href="'. route('admin.shipping_requests.proccess', $SRequest->id) .'" class="btn waves-effect waves-light btn-outline-info" title="edit">To In Proccess</a>&nbsp;';
            }
            if($SRequest->status == 'Proccess'){
                $back .= '&nbsp;<a href="'. route('admin.shipping_requests.delivered', $SRequest->id) .'" class="btn waves-effect waves-light btn-outline-info" title="edit">To Delivered</a>&nbsp;';
            }
            if($SRequest->status == 'Delivered'){
                $back .= 'Item Delivered';
            }
            return $back;

        })->rawColumns(['options','order_lines_ids'])
        ->make();
    }

    public function proccess(ShippingRequest $shippingRequest, $id){
        $shipping = $shippingRequest::find($id);
        $shipping->status = 'Proccess';
        $shipping->save();
        $status = OrderStatus::where('name','=','Processing')->get()->first();
        $order = Order::find($shipping->order_id);
        $order->status_id = $status->id;
        $order->save();
        return redirect()->back();
    }
    public function delivered(ShippingRequest $shippingRequest, $id){
        $shipping = $shippingRequest::find($id);
        $shipping->status = 'Delivered';
        $shipping->save();
        $status = OrderStatus::where('name','=','Complete')->get()->first();
        $order = Order::find($shipping->order_id);
        $order->status_id = $status->id;
        $order->save();
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ShippingRequest  $shippingRequest
     * @return \Illuminate\Http\Response
     */
    public function show(ShippingRequest $shippingRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ShippingRequest  $shippingRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(ShippingRequest $shippingRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ShippingRequest  $shippingRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShippingRequest $shippingRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ShippingRequest  $shippingRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShippingRequest $shippingRequest)
    {
        //
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Dimsav\Translatable\Translatable;
use App\Product;
use App\State;
use App\Transaction;
class Order extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'country_id',
        'address',
        'city_id',
        'state',
        'postal_code',
        'status_id',
        'user_id',
        'lat',
        'lng',
        'location_id',
        'ship_to',
        'location',
        'admin_viewed',
    ];

    public function products(){
        return $this->belongsToMany(Product::class, 'order_product')->withPivot('id','quantity', 'price', 'price_after', 'total', 'attribute_id', 'reward_points','discount_type');
    }
    public function products_weight(){
        $order = OrderProduct::where('order_id','=',$this->id)->get();
        $weight = 0;
        foreach ($order as $order_line) {
            $product = Product::find($order_line->product_id);
            $weight += ($product->length*$product->width*$product->height)/3000;
        }
        return $weight;
    }
    public function payment_method(){
        $transaction = Transaction::where('order_id','=',$this->id)->get()->first();
        return $transaction->payment_type;
    }
    public function get_shipping_request($orderline){
        $request_shipping = ShippingRequest::where('order_id','=',$this->id)->get();
        if($request_shipping->count() > 0){
            foreach($request_shipping as $rs){
                if(in_array($orderline,explode(',',$rs->order_lines_ids))){
                    return [$rs->company->name,$rs->status];
                }else{
                    return "-";
                }
            }
        }else{
            return "-";
        }
    }
    public function get_total_price(){
        return OrderProduct::where('order_id','=',$this->id)->get()->sum('price_after');
    } 
    public function status(){
        return $this->belongsTo(OrderStatus::class);
    }
    public function zone(){
        return $this->belongsTo(ShippingZone::class);
    }
    public function company(){
        return $this->belongsTo(ShippingCompany::class);
    }

    public function get_state($id){
        return State::find($id);
    }

    public function location(){
        return $this->belongsTo(Location::class);
    }

    public function Location2(){
         
        $transaction=Transaction::where('order_id',$this->id)->latest()->first();
        return Location::find($transaction->location_id);
    }
    public function get_product_return_policy($id,$created_at){
        $date1 = strtotime($created_at);
        $date2 = strtotime(now());
        $diff = abs($date2 - $date1);  
        $years = floor($diff / (365*60*60*24));  
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));  
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        $check_return = Category::find($id);
        if($check_return->return_policy > $days){
            return "true";
        }else{
            return "false";
        }
    }

    public function user()
    {
        $user=User::find($this->user_id);
        return $user;
    }

    // public function getCreatedAtAttribute($value)
    // {
    //     return \Carbon\Carbon::parse($value)->format('Y-m-d H:i');
    // }
}

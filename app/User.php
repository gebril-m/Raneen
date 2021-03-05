<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Hash;
use App\UserDetail;
use App\Wallet;
use App\Order;
use App\Point;

use App\State;
class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'provider', 'is_active', 'is_admin', 'gender', 'dob', 'contact_number', 'verification_code', 'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    function details(){
        return $this->hasOne(UserDetail::class);
    }

    function scopeCustomers($query){
        return $query->where('is_admin', 0);
    }

    function scopeAdmins($query){
        return $query->where('is_admin', 1);
    }

    function setPasswordAttribute($value){
        if(isset($value))
            $this->attributes['password'] = $value;
    }
    function wallet($user){
        return Wallet::where('user_id','=',$user)->get();
    }
    function points($user){
        return Point::where('user_id','=',$user)->get();
    }
    function orders($user){
        return Order::where('user_id','=',$user)->get();
    }
    function order_total($id){
        $order = Order::find($id);
        $total_price = 0;

        $order->products->map(function (Product $product) use (&$total_price) {
            if($product->pivot->total != $product->pivot->price_after){
                $total_price += $product->pivot->price_after;
            }else{
                $total_price += $product->pivot->total;
            }

            return $product;
        });
        return $total_price;
    }

    public function get_state($id){
        return State::find($id);
    }

}

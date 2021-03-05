<?php

namespace App\Http\Controllers\Admin;

use App\Transaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use App\User;
use App\Order;
use Hash;
use DataTables;
class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware('permission:view_admin');
        $this->middleware('permission:create_admin', ['only' => ['create','store']]);
        $this->middleware('permission:edit_admin', ['only' => ['edit','update']]);
        $this->middleware('permission:delete_admin', ['only' => ['destroy']]);
    }
    public function index()
    {
        //
        $transactions = Transaction::orderBy('id','desc')->get();
        return view ('admin.transactions.index')->with(compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data($controller = false) {

        $transactions = Transaction::query();

        // if (!\request()->get('length')) {
        //     $cities->limit(10);
        // }

        if ($controller) {
            $transactions->limit(10)->orderBy('id','DESC');
        }

        return DataTables::eloquent($transactions)
        ->addColumn('id', function (Transaction $transaction){
            return $transaction->id;
        })
        ->addColumn('user', function (Transaction $transaction){
            if($transaction->user){
                return $transaction->user->name;
            }else{
                return "";
            }
        })
        ->addColumn('order', function (Transaction $transaction){
            if($transaction->order){
                return $transaction->order->id;
            }else{
                return "";
            }
            
        })
        ->addColumn('amount', function (Transaction $transaction){
            return $transaction->amount;
        })
        ->addColumn('payment_type', function (Transaction $transaction){
            return $transaction->payment_type;
        })
        ->make();
    }
    public function create()
    {
        //
        $users = User::all();
        $orders = Order::all();
        return view('admin.transactions.create', compact('users', 'orders'));
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
        $this->validate($request,[
            'user_id'          => 'required',
            'order_id'    => 'required',
            'amount'       => 'required',
            'payment_type'       => 'required',
        ]);

        $transaction = new Transaction();
        $transaction->user_id   = $request->user_id;
        $transaction->order_id     = $request->order_id;
        $transaction->amount     = $request->amount;
        $transaction->payment_type     = $request->payment_type;
        $transaction->save();

        $logPayload = ['msg' => 'Transaction Added', 'model_id' => $transaction->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);    
        return redirect()->route('admin.transactions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}

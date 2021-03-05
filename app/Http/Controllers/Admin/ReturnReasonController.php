<?php

namespace App\Http\Controllers\Admin;

use App\ReturnReason;
use App\ReturnReasonTranslation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Language;
class ReturnReasonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->languages = Language::all();
        view()->share('languages', $this->languages);
    }
    public function index()
    {
        //
        $returns = ReturnReason::all();
        return view('admin.return_reasons.index', compact('returns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.return_reasons.create');
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
            'name.*' => 'required',
        ]);

        $return = new ReturnReason;
        $return->save();


        foreach($this->languages as $local){
            $returnTrans = new ReturnReasonTranslation();
            $returnTrans->return_reason_id = $return->id;
            $returnTrans->name = $request->input('name.'.$local->locale);
            $returnTrans->locale = $local->locale;
            $returnTrans->save();
        }
        $logPayload = ['msg' => 'Return Reason Added', 'model_id' => $return->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);    
        return redirect()->route('admin.return_reasons.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ReturnReason  $returnReason
     * @return \Illuminate\Http\Response
     */
    public function show(ReturnReason $returnReason)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReturnReason  $returnReason
     * @return \Illuminate\Http\Response
     */
    public function edit(ReturnReason $returnReason)
    {
        //
        $data = [
            'row'           => $returnReason,
        ];
        return view('admin.return_reasons.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReturnReason  $returnReason
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $return =  ReturnReason::find($id);

        $this->validate($request,[
            'name.*' => 'required',
        ]);
        $return->save();

        foreach($this->languages as $local){
            $returnTrans = ReturnReasonTranslation::where([
                'return_reason_id' => $return->id,
                'locale' => $local->locale,
            ])->first();
            if (!$returnTrans) $returnTrans = new ReturnReasonTranslation();
            $returnTrans->return_reason_id = $return->id;
            $returnTrans->name = $request->input('name.'.$local->locale);

            # $countryTrans->meta_title = $request->input('meta_title.'.$local->locale);
            # $countryTrans->meta_keywords = $request->input('meta_keywords.'.$local->locale);
            # $countryTrans->meta_description = $request->input('meta_description.'.$local->locale);
            # $countryTrans->locale = $local->locale;
            $returnTrans->save();
        }
        
        $logPayload = ['msg' => 'Reason Updated', 'model_id' => $return->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);    
        return redirect()->route('admin.return_reasons.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReturnReason  $returnReason
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReturnReason $returnReason)
    {
        //
        $returnReason->delete();
        return redirect()->route('admin.return_reasons.index');
    }
}

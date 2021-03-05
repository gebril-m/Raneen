<?php

namespace App\Http\Controllers\Admin;

use App\Country;
use App\City;
use App\Language;
use App\State;
use App\StateTranslation;
use Illuminate\Http\Request;
use App\Rules\UniqueState;
use App\Http\Controllers\Controller;
use DataTables;

class StatesController extends Controller
{

    public function __construct()
    {
        $this->languages = Language::all();
        view()->share('languages', $this->languages);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $state = State::paginate(10);
        $dataTable = $this->data(true);
        $states = $dataTable->original['data'];
        return view ('admin.states.index', compact('states'));
    }

    public function data($controller = false){

        $states = State::query();

         if (!\request()->get('length')) {
             $states->limit(10);
         }

        if ($controller) {
            $states->limit(10)->orderBy('name','ASC'); //'name','ASC' 'id','DESC'
        }

        return DataTables::eloquent($states)
            ->editColumn('city_id', function (State $state) {
                return $state->city ? $state->city->name : 0;
            })
        ->addColumn('options', function (State $state){
            $back = "";
//            $back .= '<a href="'. route('admin.states.show', $state->id) .'" class="btn waves-effect waves-light btn-outline-warning" title="edit">Show</a>';
            $back .= '&nbsp;<a href="'. route('admin.states.edit', $state->id) .'" class="btn waves-effect waves-light btn-outline-info" title="edit">Edit</a>&nbsp;';

            $back .= \Form::open(['url'=>route('admin.states.destroy', $state->id), 'class' => 'd-inline', 'onclick' => 'return confirm("Are you sure?")']);
            $back .= method_field('DELETE');
            $back .= \Form::submit('Delete', ['class' => 'btn btn-outline-danger sa-warning']);
            $back .= \Form::close();
            return $back;

        })->rawColumns(['options'])
        ->make();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::all();

        return view('admin.states.create', compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'city_id'    => 'required',
            'name.*'        => 'required',
        ]);

        $state = new State();
        $state->city_id = $request->city_id;
        $state->save();

        foreach($this->languages as $local){
            $countryTrans = new StateTranslation();
            $countryTrans->state_id = $state->id;
            $countryTrans->name = $request->input('name.'.$local->locale);

            $countryTrans->locale = $local->locale;
            $countryTrans->save();
        }
        $logPayload = ['msg' => 'State Added', 'model_id' => $state->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);
        return redirect()->route('admin.states.index');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(State $state)
    {
        $cities = City::all();
        $data = [
            'row'           => $state,
            'cities'           => $cities,
        ];
        return view('admin.states.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $state =  State::find($id);

        $this->validate($request,[
            'city_id'    => 'required',
            'name.*'        => 'required',
            #'name' => 'required|max:15|unique:states,name,' . $state->id,
        ]);

        $state->city_id = $request->city_id;
        $state->save();

        foreach($this->languages as $local){
            $stateTrans = StateTranslation::where([
                'state_id' => $state->id,
                'locale' => $local->locale,
            ])->first();
            if (!$stateTrans) $stateTrans = new StateTranslation();
            $stateTrans->state_id = $state->id;
            $stateTrans->name = $request->input('name.'.$local->locale);
            $stateTrans->save();
        }
        $logPayload = ['msg' => 'State Updated', 'model_id' => $state->id, 'user_id' => auth()->user()->id];
        logToDatabase($logPayload);
        return redirect()->route('admin.states.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(State $state)
    {
        $state->delete();

        return redirect()->route('admin.states.index');

    }
}

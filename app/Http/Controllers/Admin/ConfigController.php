<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Config;
use Auth;

class ConfigController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Bangkok');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $this->validate($request,[    
            'amount' => 'required'
        ]);

        $exists = Config::all();
        $config = new Config;
        
        if($request->input_name == "gems"){
            $config->gems_diamond_rate = $request->amount;

        }else if ($request->input_name == "diamonds") {
            $config->diamond_gems_rate = $request->amount;

        }else if ($request->input_name == "diamond_cash") {
            $config->cash_diamond_rate = $request->amount;            

        }else{
            //store cash
            $config->cash_amount = $request->amount;            
        }
        

        if(count($exists) == 0){
            // insert first time
            $config->create_by = Auth::user()->id;
            if($config->save()){
                return 1;
            }else{
                return 0;
            }
        }else{
            // Updates Existing Values
            $config->exists = true;
            $config->id = 1;
            $config->update_by = Auth::user()->id;
            if($config->save()){
                return 1;
            }else{
                return 0;
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

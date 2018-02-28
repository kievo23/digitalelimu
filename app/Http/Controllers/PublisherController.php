<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Publisher;

class PublisherController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //
        $publishers = Publisher::all();
        return view('publisher.index',compact('publishers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('publisher.create');
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
        $validator = $this->validate($request,[
            'name'=>'required|unique:class|max:255',
        ]);
        $publisher = new Publisher();
        $publisher->publisher = $request->get('name');
        $rst = $publisher->save();

        if($rst){
            return redirect('publishers/index')->with('status','Input Successful');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function show(Wallet $wallet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $publisher = Publisher::find($id);
        return view('publisher.edit',compact('publisher'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $validator = $this->validate($request,[
            'name'=>'required|max:255',
        ]);

        $publisher = Publisher::find($id);
        $publisher->publisher = $request->get('name');
        $rst = $publisher->save();

        if($rst){
            return redirect('publishers/index')->with('status','Input Successful');
        }
        
        return view('publishers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wallet $wallet)
    {
        //
    }
}

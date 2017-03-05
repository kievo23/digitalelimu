<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clas;
use App\Main;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $name;
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        //
        $classes = Clas::all();
        $category = Main::all();
        return view('class.index',compact('classes','category'));
    }
    
    public function indexSort($main)
    {
        //
        $classes = Clas::whereMainId($main)->get();
        return view('class.index',compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $mains = Main::all();
        return view('class.create',compact('mains'));
    }

     public function createId($id)
    {
        //
        $mains = Main::whereId($id)->get();
        return view('class.create',compact('mains'));
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
            'main'=>'required|max:255',
            'description'=>'required|max:255',
        ]);
        $topic = new Clas();
        $topic->name = $request->get('name');
        $topic->main_id = $request->get('main');
        $topic->description = $request->get('description');
        $rst = $topic->save();

        if($rst){
            $topics = Clas::all();
            return redirect('class/index')->with('status','Input Successful');
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
        $topic = Clas::find($id);
        $mains = Main::all();
        return view('class.edit',compact('topic','mains'));
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
        $validator = $this->validate($request,[
            'name'=>'required|max:255',
            'main'=>'required|max:255',
            'description'=>'required|max:255',
        ]);

        $topic = Clas::find($id);
        $topic->name = $request->get('name');
        $topic->main_id = $request->get('main');
        $topic->description = $request->get('description');
        $rst = $topic->save();

        if($rst){
            return redirect('class/index')->with('status','Input Successful');
        }
        
        return view('class.index',compact('topic'));
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
        $topic = Clas::find($id);
        $topic->delete();
        return redirect()->back()->with('status','Record deleted successfully');
    }
}

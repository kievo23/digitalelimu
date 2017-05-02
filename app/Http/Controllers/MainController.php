<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Main;
use Intervention\Image\Facades\Image as Image;

class MainController extends Controller
{
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
        $topics = Main::all();
        return view('main.index',compact('topics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('main.create');
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
            'name'=>'required|unique:main|max:255',
            'description'=>'required|max:255',
            'photo' => 'mimes:jpeg,png,jpg|max:800',
        ]);
        $topic = new Main();
        $topic->name = $request->get('name');
        $topic->description = $request->get('description');

        $fileName = rand(11111,99999).$request->file('photo')->getClientOriginalName();
        //$upld = $request->file('photo')->move('uploads/', $fileName);

        $img = \Image::make($request->file('photo'));
        $img->resize(100, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $upld = $img->save('uploads/'.$fileName, 100);

        $topic->photo = $fileName;
        $rst = $topic->save();

        if($rst){
            $topics = Main::all();
            return redirect('category/index')->with('status','Input Successful');
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
        $topic = Main::find($id);
        return view('main.edit',compact('topic'));
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
            'description'=>'required|max:255',
            'photo' => 'mimes:jpeg,png,jpg|max:800',
        ]);

        $topic = Main::find($id);
        $topic->name = $request->get('name');
        $topic->description = $request->get('description');
        $fileName = rand(11111,99999).$request->file('photo')->getClientOriginalName();
        //$upld = $request->file('photo')->move('uploads/', $fileName);

        $img = \Image::make($request->file('photo'));
        $img->resize(100, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $upld = $img->save('uploads/'.$fileName, 100);

        $topic->photo = $fileName;
        $rst = $topic->save();

        if($rst){
            return redirect('category/index')->with('status','Input Successful');
        }
        
        return view('category.index',compact('topic'));
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
        $topic = Main::find($id);
        $topic->delete();
        return redirect()->back()->with('status','Record deleted successfully');
    }
}

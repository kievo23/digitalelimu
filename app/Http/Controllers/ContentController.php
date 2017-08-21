<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Content;

class ContentController extends Controller
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
        $contents = Content::all();
        return view('content.index');
    }
    
    public function indexSort($id)
    {
        //
        $contents = Content::whereBookId($id)->get();
        return view('content.index');
    }    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $books = Book::all();
        return view('content.create',compact('books'));
    }

    public function createId($id)
    {
        //
        $books = Book::whereId($id)->get();
        return view('content.create',compact('books'));
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
            'name'=>'required|max:255',
            'book'=>'required|integer',
            'term'=>'required|integer',
            'week'=>'required|integer',
            'lesson'=>'required|integer',
            'description'=>'required|max:255',
            'details'=>'required',
            'audio' => 'mimes:mpga,wav,ogg,mpeg',
            'video' => 'mimes:mp4,mov,flv,avi,wmv',
        ]);
        $topic = new Content();
        $topic->name = $request->get('name');
        $topic->book_id = $request->get('book');
        $topic->term = $request->get('term');
        $topic->week = $request->get('week');
        $topic->lesson = $request->get('lesson');
        $topic->description = $request->get('description');
        $topic->details = $request->get('details');
        if($request->hasFile('audio')){
            $file = $request->file('audio');
            $fileaudio = rand(11111,99999).$file->getClientOriginalName();
            $path = public_path().'/uploads/audio/';
            $rt = $file->move($path, $fileaudio);
            $topic->audio = $fileaudio;
        }
        if($request->hasFile('video')){

            $file = $request->file('video');
            $filevideo = rand(11111,99999).$file->getClientOriginalName();
            $path = public_path().'/uploads/video/';
            $rt = $file->move($path, $filevideo);
            $topic->video = $filevideo;
        }        
        
        $rst = $topic->save();

        if($rst){
            return redirect('content/index')->with('status','Input Successful');
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
        $content = Content::find($id);
        $books = Book::all();
        return view('content.edit',compact('content','books'));
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
            'book'=>'required|integer',
            'term'=>'required|integer',
            'week'=>'required|integer',
            'lesson'=>'required|integer',
            'description'=>'required|max:255',
            'details'=>'required',            
            'audio' => 'mimes:wav,ogg,mpeg,mpga',
            'video' => 'mimes:mp4,mov,flv,avi,wmv',
        ]);

        $topic = Content::find($id);
        $topic->name = $request->get('name');
        $topic->book_id = $request->get('book');
        $topic->term = $request->get('term');
        $topic->week = $request->get('week');
        $topic->lesson = $request->get('lesson');
        $topic->description = $request->get('description');
        $topic->details = $request->get('details');
        if($request->hasFile('audio')){

            $file = $request->file('audio');
            $fileaudio = rand(11111,99999).$file->getClientOriginalName();
            $path = public_path().'/uploads/audio/';
            $rt = $file->move($path, $fileaudio);
            $topic->audio = $fileaudio;
        }
        if($request->hasFile('video')){

            $file = $request->file('video');
            $filevideo = rand(11111,99999).$file->getClientOriginalName();
            $path = public_path().'/uploads/video/';
            $rt = $file->move($path, $filevideo);
            $topic->video = $filevideo;
        }   
        $rst = $topic->save();

        if($rst){
            return redirect('content/index')->with('status','Input Successful');
        }
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
        $topic = Content::find($id);
        $topic->delete();
        return redirect()->back()->with('status','Record deleted successfully');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clas;
Use App\Book;
use Intervention\Image\Facades\Image as Image;

class BookController extends Controller
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
        ini_set('memory_limit', '-1');
        $books = Book::all();
        return view('books.index',compact('books'));
    }
    
    public function indexSort($class)
    {
        //
        $books = Book::whereClassId($class)->get();
        return view('books.index',compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $classes = Clas::all();
        return view('books.create',compact('classes'));
    }

    public function createId($id)
    {
        //
        $classes = Clas::whereId($id)->get();
        return view('books.create',compact('classes'));
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
            'name'=>'required|unique:book|max:255',
            'class'=>'required|max:255',  
            'booktype' => 'required|max:255',   
            'bookpdf' => 'required',        
            'photo' => 'required|mimes:jpeg,png,jpg|max:800',
            'description'=>'required|max:255',
        ]);
        $topic = new Book();
        $topic->name = $request->get('name');
        $topic->class_id = $request->get('class');
        $topic->booktype = $request->get('booktype');
        $topic->description = $request->get('description');
        $topic->activate = 0;

        if($request->file('photo')){
            $fileName = rand(11111,99999).$request->file('photo')->getClientOriginalName();
            //$upld = $request->file('photo')->move('uploads/', $fileName);

            $img = \Image::make($request->file('photo'));
            $img->resize(150, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $upld = $img->save('uploads/'.$fileName, 70);

            $topic->photo = $fileName;
        }
        
        if($request->file('bookpdf')){
            $fileName = str_slug($request->file('bookpdf')->getClientOriginalName().rand(11,99), ".");
            $upload = $request->file('bookpdf')->move('pdf/', $fileName);
            $topic->bookpdf = strtolower($fileName);
        }
        if($request->file('pdf')){
            $pdf = "";
            $files = $request->file('pdf');
            foreach ($files as $file) {
                $fileName = str_slug($file->getClientOriginalName().rand(11,99), ".");
                $upload = $file->move('pdf/', $fileName);
                $pdf .= $fileName.",";                
            }
            $topic->pdf = strtolower($pdf);
        }
        
        $rst = $topic->save();
        if($rst){
            $topics = Book::all();
            return redirect('book/index')->with('status','Input Successful');
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
        $book = Book::find($id);
        //return view('books.pdf',compact('book'));
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
        $book = Book::find($id);
        $classes = Clas::all();
        return view('books.edit',compact('book','classes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activate(Request $request, $id)
    {
        $topic = Book::find($id);
        $topic->activate = $topic->activate == 0 ? 1 : 0;
        $rst = $topic->save();
        if($rst){
            return redirect('book/index')->with('status','Successful');
        }
    }

    public function update(Request $request, $id)
    {
        //
        $validator = $this->validate($request,[
            'name'=>'required|max:255',
            'class'=>'required|max:255',  
            'booktype' => 'required|max:255',          
            'photo' => 'mimes:jpeg,png,jpg|max:800',
            //'pdf'=> 'mimes:pdf',
            'description'=>'required|max:255',
        ]);

        $topic = Book::find($id);
        $topic->name = $request->get('name');
        $topic->class_id = $request->get('class');
        $topic->booktype = $request->get('booktype');
        $topic->description = $request->get('description');
        $upld = true;
        if($request->file('photo')){
            $fileName = rand(11111,99999).$request->file('photo')->getClientOriginalName();
            //$upld = $request->file('photo')->move('uploads/', $fileName);

            $img = \Image::make($request->file('photo'));
            $img->resize(150, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $upld = $img->save('uploads/'.$fileName, 70);

            $topic->photo = $fileName;
        }
        $files = $request->file('pdf');
        if($request->file('bookpdf')){
            $fileName = str_slug($request->file('bookpdf')->getClientOriginalName().rand(11,99), ".");
            $upload = $request->file('bookpdf')->move('pdf/', $fileName);
            $topic->bookpdf = strtolower($fileName);
        }
        if($request->file('pdf')){
            $pdf = "";
            $files = $request->file('pdf');
            foreach ($files as $file) {
                $fileName = str_slug($file->getClientOriginalName().rand(111,999), ".");
                $upload = $file->move('pdf/', $fileName);
                $pdf .= $fileName.",";                
            }
            $topic->pdf = strtolower($pdf);
        }
        $rst = $topic->save();
        if($rst){
            $topics = Book::all();
            return redirect('book/index')->with('status','Input Successful');
        }
        
        return view('books.index',compact('topic'));
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
        $topic = Book::find($id);
        $topic->delete();
        return redirect()->back()->with('status','Record deleted successfully');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Main;
use Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Main::all();
        return view('home',['books' => $books]);
    }

    public function createBook(){
        $topics = Main::all();
        return view('books.create',compact('topics'));
    }

    public function updateBook($id){
        $book = Book::find($id);
        $topics = Main::all();
        return view('books.update',compact('book','topics'));
    }

    public function storeBook(Request $request){
        $validator = $this->validate($request,[
            'topic' => 'required|max:255',
            'description' => 'required',
            'sub_topic' => 'required',
            'details' => 'required'
        ]);

        $book = new Book();
        $book->topic = $request->get('topic');
        $book->sub_topic = $request->get('sub_topic');
        $book->description = $request->get('description');
        $book->details = $request->get('details');
        $rst = $book->save();

        if($rst){
            return redirect('/home')->with('status','Input Successful');
        }
    }

    public function updateBookDB(Request $request,$id){
        $validator = $this->validate($request,[
            'topic' => 'required|max:255',
            'description' => 'required',
            'sub_topic' => 'required',
            'details' => 'required'
        ]);

        $book = Book::find($id);
        $book->topic = $request->get('topic');
        $book->sub_topic = $request->get('sub_topic');
        $book->description = $request->get('description');
        $book->details = $request->get('details');
        $rst = $book->save();

        if($rst){
            return redirect('/home')->with('status','Update Successful');
        }
    }

    public function destroyBook($id){
        $book = Book::find($id);
        $book->delete();
        return redirect()->back()->with('status','Record deleted successfully');
    }
}
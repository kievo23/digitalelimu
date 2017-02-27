<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subscriptions;
Use App\Book;
use Carbon\Carbon;
use DB;

class SubscriptionsController extends Controller
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
        $items = Subscriptions::all();
        return view('subscriptions.index',compact('items'));
    }

    public function reports()
    {
        //
        $items = Subscriptions::all();
        return view('subscriptions.report',compact('items'));
    }

    public function reportspost(Request $request)
    {
        $date = explode("-", $request->get('daterange'));
        $startdate = Carbon::createFromFormat('m-d-Y',trim(str_replace('/', '-', $date[0])));
        $enddate = Carbon::createFromFormat('m-d-Y',trim(str_replace('/', '-', $date[1])));
        
        $items = Subscriptions::whereBetween("created_at", [$startdate,$enddate])->get();
        return view('subscriptions.report',compact('items'));
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
        //
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
        $trans = Subscriptions::find($id);
        $books = Book::all();
        return view('subscriptions.update',compact('trans','books'));
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
            'book'=>'required|max:255',
        ]);

        $topic = Subscriptions::find($id);
        $topic->book_id = $request->get('book');
        $rst = $topic->save();

        if($rst){
            return redirect('subscriptions/index')->with('status','Input Successful');
        }
        
        return view('subscriptions.index',compact('topic'));
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

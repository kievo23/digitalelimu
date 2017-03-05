<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subscriptions;
Use App\Book;
Use App\Clas;
Use App\Clients;
Use App\Edits;
use Carbon\Carbon;
use DB;

class SubscriptionsController extends Controller
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
        $items = Subscriptions::all();
        $classes = Clas::all();
        $books = Book::all();
        foreach ($items as $key => $item) {
            $item->category = self::categoryDeterminant($item->amount);
        }      
        return view('subscriptions.index',compact('items','classes','books'));
    }

    public function indexPost(Request $request)
    {
        if($request->get('book') == "" || empty($request->get('book'))){
            $items = Subscriptions::all();
        }else{
            $items = Subscriptions::whereBookId($request->get('book'))->get();
        }
        $classes = Clas::all();
        $books = Book::all();
        foreach ($items as $key => $item) {
            $item->category = self::categoryDeterminant($item->amount);
        }     
        return view('subscriptions.index',compact('items','classes','books'));
    }

    public function reports()
    {
        //
        $date = "From the beginning of Time";
        $items = Subscriptions::all();
        return view('subscriptions.report',compact('items','date'));
    }

    public function reportspost(Request $request)
    {
        $date = explode("-", $request->get('daterange'));
        $startdate = Carbon::createFromFormat('m-d-Y',trim(str_replace('/', '-', $date[0])));
        $enddate = Carbon::createFromFormat('m-d-Y',trim(str_replace('/', '-', $date[1])));
        
        $items = Subscriptions::whereBetween("created_at", [$startdate,$enddate])->get();
        $date = $request->get('daterange');
        return view('subscriptions.report',compact('items','date'));
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
        $clients = Clients::all();
        return view('subscriptions.update',compact('trans','books','clients'));
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
            'amount'=>'required|max:255',
            'client'=>'required|max:255',
        ]);

        $topic = Subscriptions::find($id);
        $topic->book_id = $request->get('book');
        $topic->amount = $request->get('amount');
        $topic->client_id = $request->get('client');
        $rst = $topic->save();

        $edit = new Edits();
        $edit->sub_id = $topic->id;
        $edit->amount = $topic->amount;
        $edit->client_id = $topic->client_id;
        $edit->save();

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

    public function categoryDeterminant($amount){
        $category = "";
        if($amount >= 5 && $amount < 15)
            $category = "Daily";
        if($amount >= 15 && $amount < 50 )
            $category = "Weekly";
        if($amount >= 50 && $amount < 100)
            $category = "Monthly";
        if($amount >= 100 && $amount < 250)
            $category = "Termly";
        if($amount >= 250 && $amount < 400)
            $category = "Yearly";
        if($amount >= 400)
            $category = "Perpetual";
        return $category;
    }
}

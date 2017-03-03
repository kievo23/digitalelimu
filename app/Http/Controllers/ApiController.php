<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Main;
use App\Rates;
use App\Clas;
use App\Content;
use Validator;
use App\Clients;
use App\Payments;
use App\Subscriptions;
use Carbon\Carbon;
use DB;

class ApiController extends Controller
{
    //
    public function getCategories(){
    	$categories = Main::all();
    	return json_encode($categories);
    }

    public function getClasses($id){
        $classes = Clas::where('main_id','=',$id)->get();
        return json_encode($classes);
    }

    public function getBooks($class){
    	$books = Book::where('class_id','=',$class)->get();
    	return json_encode($books);
    }
    
    public function getBooksSubscribed($phone,$accesstoken){
    	$client = Clients::wherePhoneAndAccesstoken($phone,$accesstoken)->first();
        if($client){
        	$str = "";
        	$result = Subscriptions::whereClientId($client->id)
                	->orderBy('id', 'DESC')
                	->get();
                foreach($result as $single){
                	$date = Carbon::createFromFormat('Y-m-d H:i:s',$single->created_at);
	            	$terminationDate = $date->addDays($single->amount/5);
	            	if(Carbon::now() > $terminationDate){
	               		$rst = null;
	            	}else{
	                	$str .= $single->book_id.",";
	            	}
                }
        }
        $str = rtrim($str,",");
        if(empty($str)){
        	$str = 0;
        }
        $books = DB::select("select * from book where id in (".$str.")");
        return json_encode($books);
    }

    public function getTerms($phone,$accesstoken,$book){
    	$client = Clients::wherePhoneAndAccesstoken($phone,$accesstoken)->first();
        if($client){
	        $terms = Content::select('book_id','term')
	        ->where('book_id','=',$book)->distinct()->get();
	}else{
		$terms = null;
	}
	return json_encode($terms);
    }

    public function getWeeks($phone,$accesstoken,$book,$term){
    	$client = Clients::wherePhoneAndAccesstoken($phone,$accesstoken)->first();
        if($client){
	        $weeks = Content::select('book_id','term','week')
	        ->where('book_id','=',$book)
	        ->where('term','=',$term)
            ->distinct()
	        ->get();
	}else{
		$weeks = null;
	}
        return json_encode($weeks);
    }

    public function getLessons($phone,$accesstoken,$book,$term,$week){
    	$client = Clients::wherePhoneAndAccesstoken($phone,$accesstoken)->first();
        if($client){
	        $lessons = Content::select('book_id','term','week','lesson')
	        ->where('book_id','=',$book)
	        ->where('term','=',$term)
	        ->where('week','=',$week)
	        ->get();
	}else{
		$lessons = null;
	}
        return json_encode($lessons);
    }

    public function getContent($phone,$accesstoken,$book,$term,$week,$lesson){
    	$client = Clients::wherePhoneAndAccesstoken($phone,$accesstoken)->first();
        if($client){
	        $content = Content::where('book_id','=',$book)
	        ->where('term','=',$term)
	        ->where('week','=',$week)
	        ->where('lesson','=',$lesson)
	        ->first();
	        $content = $content->details;
	}else{
		$content = null;
	}
	return view('books.content',compact('content'));
    }
    
    public function readBook(Request $request){
        $client = Clients::wherePhoneAndAccesstoken($request->get('phone'),$request->get('accesstoken'))->first();
        if($client){
        	$result = Subscriptions::whereClientIdAndBookId($client->id,$request->get('bookid'))
                ->orderBy('id', 'DESC')
                ->first();
            $date = Carbon::createFromFormat('Y-m-d H:i:s',$result->created_at);
            $terminationDate = $date->addDays($result->amount/5);
            if(Carbon::now() > $terminationDate){
                $rst = null;
            }else{
                $rst = $result;
            }
        }else{
            $rst = null;
        }
        return json_encode($rst);
    }
    
    
    public function getPayments(){
        $data = json_decode(utf8_encode(file_get_contents("php://input")));
        $payments = new Payments();
        $payments->transcode = $data->transactionId;
        $payments->category = $data->category;
        $payments->providerRefId = $data->providerRefId;
        $payments->source = $data->source;
        $payments->destination = $data->destination;
        $payments->accountNumber = $data->clientAccount;
        $payments->amount = $data->value;
        $payments->status = $data->status;
        $payments->jsond = file_get_contents("php://input");
        $payments->save();
        
        $client = Clients::wherePhone("0".substr($data->source,-9))->first();
        
        $sub = new Subscriptions();
        $sub->client_id = $client->id;
        $sub->book_id = substr($data->clientAccount,0,-6);
        $sub->amount = substr($data->value,4,-5);
        $sub->save();
    }
    
    public function authClient($phone,$password){
        $user = Clients::wherePhone($phone)->first();
        if ($user) {
            $user = Clients::select('id','phone','accesstoken')->wherePhoneAndPassword($phone,$password)->first();
            if(!$user){
                $result = null;
            }else{
                $user->accesstoken = md5($user->phone . date("Y-m-d h:i:sa"));;
                $user->save();
                $result = $user;
            }                
        }else{
            $token = md5($phone . date("Y-m-d h:i:sa"));
            $data = ['phone'=>$phone,'password'=>$password,'accesstoken'=>$token];
            $user = Clients::create($data);
            $result = $user;
        }
        return json_encode($result);
    }
 /*
   
    public function getContent($subtopicid){
    	$books = Book::find($subtopicid);
    	return "<div class='details'><style type='text/css'>
    .details{
        font-family: 'Nunito', sans-serif;
        color: #6b6b6b;
        padding-top:32px;
    }
    </style>".$books->details."</div>";
    }*/
}

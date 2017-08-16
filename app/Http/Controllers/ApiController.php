<?php

namespace App\Http\Controllers;

use Pesapal;
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
use Mail;

class ApiController extends Controller
{
    //

    public function getCategories(){
    	$categories = Main::where('activate',1)->get();
    	return json_encode($categories);
    }

    public function getClasses($id){
        $classes = Clas::leftJoin('main', 'main.id', '=', 'class.main_id')
        ->where('class.main_id','=',$id)
        ->where('class.activate',1)
        ->select('class.id', 'main.photo', 'class.name','class.description')
        ->get();
        foreach ($classes as $key => $class) {
            $class->books = DB::table('book')->whereClassId($class->id)->count();
        }
        return json_encode($classes);
    }

    public function getBooks($class){
    	$books = Book::where('class_id','=',$class)
        ->where('activate',1)
        ->get();
        foreach ($books as $key => $book) {
            $book->lessons = DB::table('content')->whereBookId($book->id)->count();
        }
    	return json_encode($books);
    }

    public function getBooksAll(){
        $books = Book::where('activate',1)
        ->get();
        foreach ($books as $key => $book) {
            $book->lessons = DB::table('content')->whereBookId($book->id)->count();
        }
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
        foreach ($books as $key => $book) {
            $book->lessons = DB::table('content')->whereBookId($book->id)->count();
        }
        return json_encode($books);
    }

    public function getTerms($phone,$accesstoken,$book){
    	$client = Clients::wherePhoneAndAccesstoken($phone,$accesstoken)->first();
        if($client){
	        $terms = Content::select('book_id','term')
	        ->where('book_id','=',$book)->distinct()->orderBy('term','ASC')->get();
            foreach ($terms as $key => $term) {
                $term->weeks = DB::table('content')->whereTermAndBookId($term->term,$term->book_id)->count();
            }
	}else{
		$terms = null;
	}
	return json_encode($terms);
    }

    public function getPdfList($phone,$accesstoken,$id){
        $client = Clients::wherePhoneAndAccesstoken($phone,$accesstoken)->first();
        if($client){
            $book = Book::select('pdf')->find($id);
            return json_encode($book);
        }
    }

    public function getPdf($phone,$accesstoken,$id){
        $client = Clients::wherePhoneAndAccesstoken($phone,$accesstoken)->first();
        if($client){
            $book = Book::find($id);
            return view('books.pdf',compact('book'));
        }
    }

    public function getPdfs(){
            $book = Book::find(7);
            return view('books.pdf',compact('book'));
    }

    public function getPdfFile($phone,$accesstoken,$pdf){
        $client = Clients::wherePhoneAndAccesstoken($phone,$accesstoken)->first();
        if($client){
            return view('books.pdfread',compact('pdf'));
        }
    }

    public function getWeeks($phone,$accesstoken,$book,$term){
    	$client = Clients::wherePhoneAndAccesstoken($phone,$accesstoken)->first();
        if($client){
	        $weeks = Content::select('book_id','term','week')
	        ->where('book_id','=',$book)
	        ->where('term','=',$term)
            ->distinct()
            ->orderBy('week','ASC')
	        ->get();
            foreach ($weeks as $key => $week) {
                $week->lessons = DB::table('content')->whereTermAndBookIdAndWeek($week->term,$week->book_id,$week->week)->count();
            }
	}else{
		$weeks = null;
	}
        return json_encode($weeks);
    }

    public function getLessons($phone,$accesstoken,$book,$term,$week){
    	$client = Clients::wherePhoneAndAccesstoken($phone,$accesstoken)->first();
        if($client){
	        $lessons = Content::select('book_id','term','week','lesson','audio','video')
	        ->where('book_id','=',$book)
	        ->where('term','=',$term)
	        ->where('week','=',$week)
            ->orderBy('lesson','ASC')
	        ->get();
	}else{
		$lessons = null;
	}
        return json_encode($lessons);
    }

    public function getContent($phone,$accesstoken,$book,$term,$week,$lesson){
    	$client = Clients::wherePhoneAndAccesstoken($phone,$accesstoken)->first();
        if($client){

            $result = Subscriptions::whereClientIdAndBookId($client->id,$book)
                ->orderBy('id', 'DESC')
                ->first();
            $date = Carbon::createFromFormat('Y-m-d H:i:s',$result->created_at);
            $terminationDate = $date->addDays(self::daysDeterminant($result->amount));
            if(Carbon::now() > $terminationDate){
                $content = null;
            }else{                
                $content = Content::where('book_id','=',$book)
                ->where('term','=',$term)
                ->where('week','=',$week)
                ->where('lesson','=',$lesson)
                ->first();
                if($content == null){
                    $content == null;
                }else{
                    $content = $content->details;
                }                
            }
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
            $terminationDate = $date->addDays(self::daysDeterminant($result->amount));
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
    
    public function getPesapal(){
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

    public function registerClient(Request $request){
        $cuser = Clients::wherePhone($request->get('phone'))->first();
        if($cuser){
            $user = new Clients;
            $user->phone = null;
            return json_encode($user);
        }else{
            $token = md5($request->get('phone') . date("Y-m-d h:i:sa"));
            $data = ['phone'=>$request->get('phone'),'password'=>$request->get('password'),'accesstoken'=>$token,'email'=>$request->get('email')];
            $user = Clients::create($data);
            if($user){
                Mail::send('emails.welcome', ['username'=> $user->phone ,'password'=> $user->password,'user' => $user], function ($message) use ($user) {
                    $message->to($user->email)->subject('Registration Successful');
                });
                return json_encode($user);
            }
            return json_encode(new Clients);
        }
    }

    public function resetPassword($phone){
        $user = Clients::wherePhone($phone)->first();
        if($user){
            $code = rand(11111,99999);
            $user->resetcode = $code;
            if($user->save()){
                Mail::send('emails.passwordreset', ['resetcode'=> $user->resetcode,'user' => $user], function ($message) use ($user) {
                    $message->to($user->email)->subject('Password Reset');
                });
                return json_encode($user);
            }else{
                return json_encode(null);
            }            
        }
    }

    public function verifyResetCode($phone,$code){
        $user = Clients::wherePhoneAndResetcode($phone,$code)->first();
        if($user){
            return 1;
        }else{
            return 0;
        }
    }

    public function newpassword($phone,$newpassword,$code){
        $user = Clients::wherePhoneAndResetcode($phone,$code)->first();
        if($user){
            $user->password = $newpassword;
            if($user->save()){
                Mail::send('emails.newpassword', ['newpassword'=> $newpassword,'username'=>$user->phone,'user' => $user], function ($message) use ($user) {
                    $message->to($user->email)->subject('New Password');
                });
                return json_encode(1);
            }else{
                return json_encode(0);
            }
        }else{
            return json_encode(0);
        }
    }

    public function daysDeterminant($amount){
        $days = "";
        if($amount >= 5 && $amount < 15)
            $days = $amount/5;
        if($amount >= 15 && $amount < 50 )
            $days = $amount * (7 / 15);
        if($amount >= 50 && $amount < 100)
            $days = $amount * (30/50);
        if($amount >= 100 && $amount < 250)
            $days = $amount * (120/100);
        if($amount >= 250 && $amount < 400)
            $days = $amount * (365/250);
        if($amount >= 400)
            $days = 5000;
        return $days;
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

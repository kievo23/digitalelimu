<?php
include_once('OAuth.php');
session_start();
/*
PesaPal Sandbox is at http://demo.pesapal.com. Use this to test your developement and 
when you are ready to go live change to https://www.pesapal.com.
*/
$consumer_key="roIpBWqRZAVUKX8KCUgr2l2oFVSJ/kzE";//Register a merchant account on
                   //demo.pesapal.com and use the merchant key for testing.
                   //When you are ready to go live make sure you change the key to the live account
                   //registered on www.pesapal.com!
$consumer_secret="2eLiIH9Q0esLIbGGL/I8PYcI4Wo=";// Use the secret from your test
                   //account on demo.pesapal.com. When you are ready to go live make sure you 
                   //change the secret to the live account registered on www.pesapal.com!
$statusrequestAPI = 'https://www.pesapal.com/api/querypaymentstatus';//change to      
                   //https://www.pesapal.com/api/querypaymentstatus' when you are ready to go live!
//print_r($_GET);
// Parameters sent to you by PesaPal IPN
$pesapalNotification=$_GET['pesapal_notification_type'];
$pesapalTrackingId=$_GET['pesapal_transaction_tracking_id'];
$pesapal_merchant_reference=$_GET['pesapal_merchant_reference'];

if($pesapalTrackingId!='')
{
   $token = $params = NULL;
   $consumer = new OAuthConsumer($consumer_key, $consumer_secret);
   $signature_method = new OAuthSignatureMethod_HMAC_SHA1();

   //get transaction status
   $request_status = OAuthRequest::from_consumer_and_token($consumer, $token, "GET", $statusrequestAPI, $params);
   $request_status->set_parameter("pesapal_merchant_reference", $pesapal_merchant_reference);
   $request_status->set_parameter("pesapal_transaction_tracking_id",$pesapalTrackingId);
   $request_status->sign_request($signature_method, $consumer, $token);

   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $request_status);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($ch, CURLOPT_HEADER, 1);
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
   if(defined('CURL_PROXY_REQUIRED')) if (CURL_PROXY_REQUIRED == 'True')
   {
      $proxy_tunnel_flag = (defined('CURL_PROXY_TUNNEL_FLAG') && strtoupper(CURL_PROXY_TUNNEL_FLAG) == 'FALSE') ? false : true;
      curl_setopt ($ch, CURLOPT_HTTPPROXYTUNNEL, $proxy_tunnel_flag);
      curl_setopt ($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
      curl_setopt ($ch, CURLOPT_PROXY, CURL_PROXY_SERVER_DETAILS);
   }

   $response = curl_exec($ch);

   $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
   $raw_header  = substr($response, 0, $header_size - 4);
   $headerArray = explode("\r\n\r\n", $raw_header);
   $header      = $headerArray[count($headerArray) - 1];

    $servername = "localhost";
    $username = "root";
    $password = "TpkvgZ3PqPU4hRNA";
    $dbname = "digitalElimu";
    $client = $_SESSION['client'];
    $amount = (int)$_SESSION['amount'];
    $class = $_SESSION["class"];

    
    $today = date("Y-m-d H:i:s"); 

   //transaction status
   $elements = preg_split("/=/",substr($response, $header_size));
   /*echo "Elements<pre>";
   print_r($elements);
   echo "</pre>";

   echo "response<pre>";
   print_r($response);
   echo "</pre>";*/
   $status = $elements[1];
   //print_r($_SESSION);

        
    //if($status){
      try {

          $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
          // set the PDO error mode to exception
          //print_r($conn);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $statement = $link->prepare("INSERT INTO payments (client_id, book_id, amount, created_at, updated_at)
                  VALUES(:id, :transcode, :category, :providerRefId, :providerRefId, :source, :destination, :created_at, :updated_at)");
                $statement->execute(array(
                    "client_id" => $client_id,
                    "book_id" => $book['id'],
                    "amount" => $pricePerBook,
                    "created_at" => $today,
                    "updated_at" => $today
                ));

          $stmt = $conn->prepare("SELECT `id`,`phone` FROM clients where phone='".$client."'"); 
          $stmt->execute();
          $cliented = $stmt->fetch(PDO::FETCH_ASSOC); 
          $client_id = $cliented['id'];

          $class = $conn->prepare("SELECT * FROM book where class_id='".$class."'"); 
          $class->execute();
          $class = $class->fetch(PDO::FETCH_ASSOC); 

          $booksNo = count($class);
          $pricePerBook = priceDeterminantclass($amount,$booksNo);

            foreach($books as $book){
                $statement = $link->prepare("INSERT INTO subscriptions (client_id, book_id, amount, created_at, updated_at)
                  VALUES(:client_id, :book_id, :amount, :created_at, :updated_at)");
                $statement->execute(array(
                    "client_id" => $client_id,
                    "book_id" => $book['id'],
                    "amount" => $pricePerBook,
                    "created_at" => $today,
                    "updated_at" => $today
                ));
                echo "<h2>Successfully Subscribed to this book</h2>";
            }
          }
      catch(PDOException $e)
          {
          echo $sql . "<br>" . $e->getMessage();
          }
    //}
      $conn = null;
   }
   curl_close ($ch);
   
   //UPDATE YOUR DB TABLE WITH NEW STATUS FOR TRANSACTION WITH pesapal_transaction_tracking_id $pesapalTrackingId

   if(DB_UPDATE_IS_SUCCESSFUL)
   {
      $resp="pesapal_notification_type=$pesapalNotification&pesapal_transaction_tracking_id=$pesapalTrackingId&pesapal_merchant_reference=$pesapal_merchant_reference";
      ob_start();
      //echo $resp;
      ob_flush();
      exit;
   }


   public function priceDeterminantclass($amount,$booksNo){
        $pricePerBook = 0;
        if($amount < 25)
            $pricePerBook = 0;
        if($amount >= 25 && $amount < 75)
            $pricePerBook = ($amount/$booksNo < 5) ? 5 : $amount/$booksNo;
        if($amount >= 75 && $amount < 250 )
            $pricePerBook = ($amount/$booksNo < 15) ? 15 : $amount/$booksNo;
        if($amount >= 50 && $amount < 100)
            $pricePerBook = ($amount/$booksNo < 50) ? 50 : $amount/$booksNo;
        if($amount >= 100 && $amount < 250)
            $pricePerBook = ($amount/$booksNo < 100) ? 100 : $amount/$booksNo;
        if($amount >= 250)
            $pricePerBook = ($amount/$booksNo < 250) ? 250 : $amount/$booksNo;
        return $pricePerBook;
    }
?>
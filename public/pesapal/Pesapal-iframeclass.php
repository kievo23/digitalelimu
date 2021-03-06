<?php
include_once('OAuth.php');


session_start();
$classid = $_GET['class_id'];
$client = $_GET['client'];
//print_r($_GET);

if(isset($_POST['submit'])){
	//pesapal params
	$token = $params = NULL;

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
	$signature_method = new OAuthSignatureMethod_HMAC_SHA1();
	$iframelink = 'https://www.pesapal.com/api/PostPesapalDirectOrderV4';//change to      
	                   //https://www.pesapal.com/API/PostPesapalDirectOrderV4 when you are ready to go live!

	//get form details
	
	$amount = $_POST['amount'];
	$amount = number_format($amount, 2);//format amount to 2 decimal places

	$desc = $_POST['description'];
	$type = $_POST['type']; //default value = MERCHANT
	$reference = $_POST['reference'];//unique order id of the transaction, generated by merchant
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$email = $_POST['email'];
	$phonenumber = '';//ONE of email or phonenumber is required
	$_SESSION["amount"] = $amount;
    $_SESSION["client"] = $client;
    $_SESSION["class"] = $classid;

	$callback_url = 'http://139.59.187.229/pesapal/Pesapal-ipnclass.php'; //redirect url, the page that will handle the response from pesapal.

	$post_xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?><PesapalDirectOrderInfo xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" Amount=\"".$amount."\" Description=\"".$desc."\" Type=\"".$type."\" Reference=\"".$reference."\" FirstName=\"".$first_name."\" LastName=\"".$last_name."\" Email=\"".$email."\" PhoneNumber=\"".$phonenumber."\" xmlns=\"http://www.pesapal.com\" />";
	$post_xml = htmlentities($post_xml);

	$consumer = new OAuthConsumer($consumer_key, $consumer_secret);

	//post transaction to pesapal
	$iframe_src = OAuthRequest::from_consumer_and_token($consumer, $token, "GET", $iframelink, $params);
	$iframe_src->set_parameter("oauth_callback", $callback_url);
	$iframe_src->set_parameter("pesapal_request_data", $post_xml);
	$iframe_src->sign_request($signature_method, $consumer, $token);
	?>
	<!DOCTYPE html>
<html>
<head>
	<title>Pesapal Payment</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body style="">
	<div class="container">
		<iframe src="<?php echo $iframe_src;?>" width="100%" height="1200px"  scrolling="no" frameBorder="0">
			<p>Browser unable to load iFrame</p>
		</iframe>
	</div>		
</body>
</html>
<?php
}else{

//display pesapal - iframe and pass iframe_src
?>
<!DOCTYPE html>
<html>
<head>
	<title>Pesapal Payment</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body style="">
	<div class="container">
		<form method="post" action="" class="form-horizontal">
			<input type="text" name="first_name" value="" placeholder="first name" class="form-control" style="margin:10px">	
			<input type="text" name="last_name" value="" placeholder="last Name"  class="form-control" style="margin:10px">
			<input type="hidden" name="description" value="Book subscription on Digital Elimu" readonly="readonly" style="margin:10px">
			<input type="hidden" name="reference" value="<?php echo $classid ?>" readonly="readonly">
			<input type="text" name="email" placeholder="email"  class="form-control" style="margin:10px">
			<input type="hidden" name="type" value="MERCHANT" readonly="readonly" />
			<input type="text" name="amount" placeholder="amount"  class="form-control" style="margin:10px">
			<input type="submit" name="submit" value="Subscribe"  class="form-control btn btn-primary">
		</form>
		<iframe src="<?php echo $iframe_src;?>" width="100%" height="700px"  scrolling="yes" frameBorder="0">
			<p>Browser unable to load iFrame</p>
		</iframe>
	</div>		
</body>
</html>
<?php } ?>

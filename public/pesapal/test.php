<?php
$client = "0722779770";
    $amount = 5;
    $book = "4";
    $servername = "localhost";
    $username = "root";
    $password = "TpkvgZ3PqPU4hRNA";
    $dbname = "digitalElimu";
    $today = date("Y-m-d H:i:s"); 

    try {
          $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
          // set the PDO error mode to exception
          //print_r($conn);
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $stmt = $conn->prepare("SELECT `id`,`phone` FROM clients where phone='".$client."'"); 
          print_r($stmt);
          $stmt->execute();
          $client = $stmt->fetch(PDO::FETCH_ASSOC); 
          $client_id = $client['id'];
          echo "Client Id<br>";
          print_r($client_id);

          $sql = "INSERT INTO subscriptions (client_id, book_id, amount, created_at, updated_at)
          VALUES ($client_id, $book, '$amount', '$today', '$today')";
          // use exec() because no results are returned
          $rst = $conn->exec($sql);
          echo "SQL<br>";
          print_r($sql);
          echo "Result<br>";
          print_r($rst);
          echo "<h2>Successfully Subscribed to this book</h2>";
          }
      catch(PDOException $e)
          {
          echo $sql . "<br>" . $e->getMessage();
          }
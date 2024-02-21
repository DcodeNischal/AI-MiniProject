<?php

    // session_start();
    // if(!isset($_SESSION['email'])){
    //     header('Location: login.php');
    // }


    error_reporting(E_ALL);
ini_set('display_errors', 1);
$sentiment_score = 0;
$sentiment = null;
// Get the text from the form
if (isset($_POST['submit'])) {
    $text = $_POST['text'];

    $data = array('text' => $text);
$data_string = json_encode($data);

// Initialize cURL session
$ch = curl_init('http://0.0.0.0:8000/sentiment/');

// Set cURL options
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data_string))
);

// Execute the cURL request
$result = curl_exec($ch);

// Close cURL session
curl_close($ch);

// Decode the JSON response
$response = json_decode($result, true);

// Get the sentiment score from the response
$sentiment_score = $response['sentiment_score'];



if($sentiment_score > 0.1){
    $sentiment = "Positive";
}else if($sentiment_score < -0.1){
    $sentiment = "Negative";
}else{
    $sentiment = "Neutral";
}


// Display the sentiment score

}

// Prepare the data to be sent in the request


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>

<form action="" method="post">
    <input type="text" name="text" placeholder="Enter text">
    <input type="submit" value="Submit" name="submit">
</form>

<h1>Score : <?php echo $sentiment_score;?></h1>
<h1>Sentiment : <?php echo $sentiment;?></h1>
    
</body>
</html>
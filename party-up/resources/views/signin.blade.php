<?php 

$client_id = "2906e624-6097-43da-829a-5e0d6e0fcf7d";
$redirect_uri = "https://ec2-35-166-105-107.us-west-2.compute.amazonaws.com/access";
$client_secret = "d44c7d02-ddd5-46a3-a6a2-68890abbd561";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <a href="https://staging-api.moj.io/OAuth2/authorize?response_type=token&client_id=<?=$client_id?>&redirect_uri=<?=$redirect_uri?>"><button>Login With Mojio</button></a>
    <form action="/signin" method="post">
        <input type="text">
        <input type="submit" value="Submit">
    </form>
</body>
</html>
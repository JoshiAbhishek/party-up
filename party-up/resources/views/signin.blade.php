<?php 

$client_id = "6759045b-9266-4d79-be65-a06f92b9e059";
$redirect_uri = "duncanandrew.com";
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
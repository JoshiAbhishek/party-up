<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
<script>
    var match = document.location.hash.match(/access_token=([0-9a-f-]{36})/);
    var access_token = !!match && match[1];

    var match = document.location.hash.match(/expires_in=([0-9]*)/);
    var expires_in = !!match && match[1];

    console.log(access_token);
    console.log(expires_in);

    window.location.href = '/signin/' + access_token + '/' + expires_in;
</script>

</body>
</html>
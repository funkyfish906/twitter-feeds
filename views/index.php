<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Tweet feeds</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css">
    <script type="application/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
</head>
<body>
<div class="container">
    <h1>Main</h1>

    <a href="/create">add user</a>
    <br>
    <a href="/delete">remove user</a>
    <?php
        $id = uniqid();
        $secret = sha1($id);
    ?>
    <br>
    <a href="/feed?id=<?php echo $id?>&secret=<?php echo $secret?>">feeds</a>
</div>
</body>
</html>
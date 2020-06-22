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
    <p>
        <a href="/">Home</a>
    </p>
    <h1>Feeds</h1>

    <?php
    if ($result) {
        $result = json_decode($result, true);
        echo '<ul class="list">';
        foreach ($result['feed'] as $item){
            echo '<li>'.$item['user'].' '.$item['tweet'].'</li>';
            if (!empty($item['hashtag'])){
                echo '<li>';
                foreach($item['hashtag'] as $tag){
                    echo $tag['text'].'<br>';
                }
                echo '</li>';
            }
        }
        echo '</ul>';
    } else {
        echo json_encode(
            ["message" => "No tweets found."]
        );
    }
    ?>
</div>
</body>
</html>

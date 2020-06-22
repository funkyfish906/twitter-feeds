<?php

include_once 'api/config.php';
include_once 'api/database.php';
include_once 'api/config.php';


$database = new Database($database['host'], $database['db_name'], $database['username'], $database['password']);
$db = $database->getConnection();

$request = $_SERVER['REDIRECT_URL'];

switch ($request) {
    case '/add' :
        require __DIR__ . '/api/actions/user.php';
        $user = new UserAction($db);
        $user->addUser($_GET);
        break;
    case '' :
        require __DIR__ . '/views/index.php';
        break;
    case '/feed' :
        require __DIR__ . '/api/actions/feeds.php';
        $feeds = new Feeds($access, $db);
        $result = $feeds->getTweets($_GET);

        require __DIR__ . '/views/feeds.php';
        break;
    case '/remove' :
        require __DIR__ . '/api/actions/user.php';
        $user = new UserAction($db);
        $user->deleteUser($_GET);
        break;

    case '/create' :
        require __DIR__ . '/views/create.php';
        break;
    case '/delete' :
        require __DIR__ . '/views/delete.php';
        break;
    default:
        require __DIR__ . '/views/404.php';
        break;
}

?>
<?php
include_once 'api/actions/validate.php';
include_once 'api/objects/user.php';

class Feeds{

    private $access;
    private $required = ['id', 'secret'];


    public function __construct($access,$db){
        $this->access = $access;
        $this->conn = $db;
    }

    public function buildBaseString($baseURI, $method, $params) {
        $r = array();
        ksort($params);
        foreach($params as $key=>$value){
            $r[] = "$key=" . rawurlencode($value);
        }
        return $method."&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r));
    }

    public function buildAuthorizationHeader($oauth) {
        $r = 'Authorization: OAuth ';
        $values = array();
        foreach($oauth as $key=>$value)
            $values[] = "$key=\"" . rawurlencode($value) . "\"";
        $r .= implode(', ', $values);
        return $r;
    }

    public function getUsers() {
        $user = new User($this->conn);
        $users = $user->getAll();
        return $users;
    }

    public function getTweets($parameters)
    {
        if (!Validate::checkAccess($parameters)){
            echo json_encode(['error' => 'access denied']);
            return;
        }
        elseif(!Validate::checkParameters($this->required, $parameters)){
            echo json_encode(['error' => 'missing parameter']);
            return;
        }


        $users = $this->getUsers();

        $count = ($parameters['count']) ?? '5';
        foreach ($users as $user) {
            $oauth = array(
                'oauth_consumer_key'        => $this->access['consumer_key'],
                'oauth_nonce'               => time(),
                'oauth_signature_method'    => 'HMAC-SHA1',
                'oauth_token'               => $this->access['oauth_access_token'],
                'oauth_timestamp'           => time(),
                'oauth_version'             => '1.0'
            );

            $request = array(
                'screen_name'       => $user,
                'count'             => $count
            );

            $oauth = array_merge($oauth, $request);

            $base_info = $this->buildBaseString("https://api.twitter.com/1.1/statuses/user_timeline.json", 'GET', $oauth);
            $composite_key = rawurlencode($this->access['consumer_secret']) . '&' . rawurlencode($this->access['oauth_access_token_secret']);
            $oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
            $oauth['oauth_signature'] = $oauth_signature;

            //  make request
            $header = array($this->buildAuthorizationHeader($oauth), 'Expect:');
            $options = array(CURLOPT_HTTPHEADER => $header,
                CURLOPT_HEADER => false,
                CURLOPT_URL => "https://api.twitter.com/1.1/statuses/user_timeline.json?" . http_build_query($request),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false);

            $feed = curl_init();
            curl_setopt_array($feed, $options);
            $tweets = json_decode(curl_exec($feed));
            curl_close($feed);
            foreach ($tweets as $tweet) {
                $result[] = ['user' => $user,
                             'tweet' => $tweet->text,
                             'hashtag' => $tweet->entities->hashtags
                ];
            }
        }

        shuffle($result);

       return json_encode(['feed' => $result]);

    }
}

?>
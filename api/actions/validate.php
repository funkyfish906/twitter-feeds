<?php

class Validate
{

    public static function checkAccess(array $parameters)
    {
        $str = '';
        $secret = $parameters['secret'];
        unset($parameters['secret']);
        foreach ($parameters as $parameter) {
            $str.=$parameter;
        }

        if (sha1($str) === $secret){
            return true;
        }
        else
            return false;
    }

    public static function checkParameters(array $required, array $parameters)
    {
        if (empty(array_diff($required, array_keys($parameters)))){
            return true;
        }
        else
            return false;
    }

}

?>
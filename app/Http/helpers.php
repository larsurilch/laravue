<?php

function message($string)
{
    $json = json_decode(file_get_contents(public_path() . '/message.json'));
    return $json->$string;
}

function toSQL($value)
{
    if($value) {
        $date = explode('/', $value);
        return $date[2] . '-' . $date[1] . '-' . $date[0];
    }

    return null;
}
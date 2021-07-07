<?php

function dnd($data)
{
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
}

function pnd($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

$uri = $_SERVER['REQUEST_URI'];
pnd(parse_url($uri));

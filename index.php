<?php
use Raymonds\Orm\OrmManager;

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


$em = new OrmManager()

$uri = $_SERVER['REQUEST_URI'];
pnd(parse_url($uri));

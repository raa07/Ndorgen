<?php

function Dorgen()
{
    return App\Dorgen::getInstance();
}

function redirect($url)
{
    header('Location: http://'.Dorgen()->getDomain().'/'.$url);
    return true;
}
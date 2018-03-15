<?php

namespace Tools\Generators;

abstract class Generator
{
    protected function errorLoging($error)
    {
        die($error);//TODO: реализовать логинг нормальный
    }
}
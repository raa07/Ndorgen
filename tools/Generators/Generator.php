<?php

namespace Tools\Generators;

abstract class Generator
{
    abstract protected function generateElement();
    protected function errorLoging($error)
    {
        die($error);//TODO: реализовать логинг нормальный
    }
}
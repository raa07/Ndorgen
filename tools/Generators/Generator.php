<?php

namespace Tools\Generators;

abstract class Generator
{
    abstract protected function generateElement($length);
    abstract protected function errorLoging($error);
    abstract protected function selectRelatedElement();
}
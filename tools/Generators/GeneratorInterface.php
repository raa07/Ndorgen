<?php

namespace Tools\Generators;

interface  GeneratorInterface
{
    public static function runAllGenerators();
    public static function runPostsGenerator();
    public static function runCommentsGenerator();
    public static function runUsersGenerator();
}
<?php

namespace Tools\Generators\Generators;

use App\Models\Users;
use Tools\Generators\Generator;
use Tools\Generators\GeneratorInterface;
use Tools\Parsers\User\VkUserParser;

class UsersGenerator extends Generator implements GeneratorInterface
{
    public function generateElements($result_count):array
    {
        $user_parser = new VkUserParser();
        $user_model = new Users();
        $parsed_users = $user_parser->run($result_count);

        $result = [];

        foreach ($parsed_users as $parsed_user) {
            $avatar = $this->save_avatar($parsed_user['avatar']);
            $result[] = $user_model->createUser($parsed_user['name'], $avatar);
        }

        return $result;
    }

    private function save_avatar(string $avatar):string
    {
        $ext = preg_split('/\./', $avatar);
        $ext = end($ext);

        $image = @file_get_contents($avatar);
        if(!$image){
            return '';
        }

        while (true) {
            $filename = uniqid(rand(), true) . '.' . $ext;
            $img = dirname(__FILE__) . '/../../../public/images/avatars/'.$filename;
            if (!file_exists($img)) break;
        }

        $save_result = @file_put_contents($img, $image);
        if(!$save_result){
            return '';
        }

        return $filename;
    }
}
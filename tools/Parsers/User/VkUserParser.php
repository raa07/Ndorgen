<?php

namespace Tools\Parsers\User;

class VkUserParser extends UserParser implements UserParserInterface
{
    private function compareUrl(int $result_count):string
    {
        $ids = '';//id пользователей
        for ($x=0; $x < $result_count; $x++)
        {
            $ids.= ','.mt_rand(10000, 371529051);//рандомно подбираем id Для каждого пользователя
        }

        $url = 'https://api.vk.com/method/users.get.json?v=5.52&lang=ru&user_ids='.$ids.'&name_case=nom&fields=city,country,status,photo_100';

        return $url;
    }

    private function requestApi(string $url):array
    {
        $proxy = \App\Config::get('generators')['proxy'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_PROXY, $proxy);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
//        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 6);

        $data = curl_exec($ch);

        $result = json_decode($data, true);

        $result = isset($result['response']) ? $result['response'] : [];

        return $result;
    }

    protected function getUsers(int $result_count):array
    {
        $url = $this->compareUrl($result_count);
        $raw_users = $this->requestApi($url);
        $users = [];

        foreach($raw_users as $raw_user){
            $new_user = [];
            if($raw_user['first_name']!='' && $raw_user['last_name']!='')//если есть нужные поля
            {
                $new_user['name'] = $raw_user['first_name'].' '.$raw_user['last_name'];//сохраняем имя польхователя
                $new_user['avatar'] = $raw_user['photo_100'];//сохраняем ссылку на аву
                $users[] = $new_user;
            }
        }

        return $users;
    }

}
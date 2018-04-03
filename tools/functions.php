<?php

function Dorgen()
{
    return App\Dorgen::getInstance();
}

function redirect($url)
{
    header('Location: http://'.$_SERVER['SERVER_NAME'].'/'.$url);
    return true;
}

function transcriptLink($link) //фунция для транскрипта названий постов в ссылки для них
{
    $link = mb_strtolower(strip_tags($link), 'utf-8');
    $rustitle = ['а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я',' ','_','ґ','є','ї','ў','і','ђ','đ','ž','љ','ћ','ć','č','џ','ñ','ö','ß','ü','.',',',';','š','ë','í','ó','é','ě','á','å','ä','ā','õ','ē','ū','ô','ī','ė','â','è','ň','ú','ō','ş','ã','ţ','ă','ź','ł','ń','ø','ḩ','ð','à','ï'];
    $engtitle = ['a','b','v','g','d','e','e','j','z','i','j','k','l','m','n','o','p','r','s','t','u','f','h','ts','ch','sh','sch','','i','','e','yu','ya','-','-','g','e','i','u','i','dj','dj','z','l','c','c','c','dz','n','o','b','u','-','-','-','s','e','i','o','e','e','a','a','a','a','o','e','u','o','i','e','a','e','n','u','o','s','a','t','a','z','l','n','o','h','th','a','i'];
    $link = str_replace ($rustitle, $engtitle, $link);
    $link = str_replace ('--', '-', $link);
    $link = preg_replace("/[^a-z0-9\-]/","",$link);
    $link = trim($link);
    if ($link === '') $link = md5($link);

    return $link;
}
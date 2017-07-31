<?php
/**
 * Created by PhpStorm.
 * User: Anton
 * Date: 30.07.2017
 * Time: 20:14
 */

function parsePropertyTag($key, $tag){
    $allPropTag = explode(" ",$tag);
    $TegName = $allPropTag[0];
    preg_match_all('/[ ]+([^= ]+)[="]+([\w- ]+)["]+/i', $tag, $property);
    print_r($property);

}

function parseHtml($html){
    preg_match_all ( '/<([^>]+)>/i' , $html , $tags); //все теги

    foreach ($tags[1] as $key=>$tag){
        if (count(explode(" ",$tag)) > 1){
            parsePropertyTag($key, $tag);
        }
    }
}


$html = file_get_contents("http://university.netology.ru/user_data/tarutin/bitrix/index.html");


//$dom = new DOMDocument;
//
//$dom->loadHTML($html);

parseHtml($html);


//preg_match_all ( '/<([^>]+)>/i' , $html , $tags); //все теги без значений

//preg_match_all ( '/(<[^>]+?[^>]+>)(.*?)<[^>]+?[^>]+>/i' , $html , $variable); // значения тегов

//preg_match_all ( '/([^=]+)[="]+([\w-]+)["]+/i' , $str[1] , $property); //

